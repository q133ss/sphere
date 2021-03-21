<template>
	<div class="card mb-1">
		<div class="card-header p-1 d-flex justify-content-between align-items-center">
			<span>Видеотрансляция</span>
			<div class="float-right">
				<div v-if="callPlaced">
					<button type="button" class="btn mx-1 btn-sm btn-info" @click="toggleMuteAudio"><i class="fa" :class="{ 'fa-microphone': !mutedAudio, 'fa-microphone-slash': mutedAudio}"></i></button>
					<button type="button" class="btn mx-1 btn-sm btn-primary" @click="toggleMuteVideo"><i class="fa" :class="{ 'fa-eye': !mutedVideo, 'fa-eye-slash': mutedVideo}"></i></button>
					<button type="button" class="btn mx-1 btn-sm btn-danger" @click="endCall"><i class="fa fa-times"></i></button>
				</div>
				<div v-else>
					<button type="button" class="btn btn-sm" @click="callUser" :disabled="!userIsOnline || callMe" :class="{'btn-success': userIsOnline, 'btn-danger': !userIsOnline}">
						<i class="fa fa-volume-control-phone"></i> {{ user.name }}
					</button>
				</div>
			</div>
		</div>
		<div class="card-body p-1">
			<div id="lesson-video-container" class="position-relative">
			<div v-show="callPlaced">
				<video id="localVideo" ref="userVideo" muted playsinline autoplay class="cursor-pointer" :class="isFocusMyself === true ? 'user-video' : 'partner-video'" @click="toggleCameraArea"/>
				<video id="remoteVideo" ref="partnerVideo" playsinline autoplay class="cursor-pointer" :class="isFocusMyself === true ? 'partner-video' : 'user-video'" @click="toggleCameraArea" v-if="callAccepted" />
			</div>
			<div class="partner-video">
				<div v-if="callFromMe" class="column items-center q-pt-xl">
					<div class="col q-gutter-y-md text-center">
						<p>Идет вызов...</p>
					</div>
				</div>
				<div v-if="callDecline" class="column items-center q-pt-xl">
					<div class="col q-gutter-y-md text-center">
						<p>Звонок отменен пользователем</p>
					</div>
				</div>
			</div>
			<div class="text-center" v-if="callMe">
				<p>Входящий вызов</p>
				<div class="btn-group" role="group">
					<button type="button" class="btn btn-sm btn-danger" @click="declineCall">Сброс</button>
					<button type="button" class="btn btn-sm btn-success" @click="acceptCall">Принять</button>
				</div>
			</div>
			</div>
		</div>
	</div>
</template>

<script>
import Peer from "simple-peer"; 
import { getPermissions } from "../helpers";
export default {
	props: ['user', 'auth', 'lesson_id'],
	data() {
		return {
			audioIn: false,
			audioOut: false,
			turn_url: [
				'stun:stun.l.google.com:19302',
				'stun:global.stun.twilio.com:3478'
			],
			callFromMe: false,
			callMe: false,
			callDecline: false,
			channel: false,
			userIsOnline: false,
			stream: false,
			isFocusMyself: true,
			callPlaced: false,
			callAccepted: false,
			callPartner: null,
			mutedAudio: false,
			mutedVideo: false,
			peer: null,
			signal: false,
		};
	},

	mounted() {
		this.channel = Echo.join("App.Models.Lesson." + this.lesson_id + '.Video')
		.here(users => {
			if(users.findIndex( u => u.id == this.user.id) > -1) this.userIsOnline = true
		})
		.joining( user => {
			this.userIsOnline = true
			this.$toast.success(user.name + ' присоединился к уроку')
		})
		.leaving( user => {
			this.callFromMe = false
			this.callPlaced = false
			this.userIsOnline = false
			this.$toast.warning(user.name + ' покинул урок')
		})
		.listenForWhisper("callDecline", data => {
			this.callDecline = true;
			this.callFromMe = false;
			this.callPlaced = false;
			this.stop('out');
		})
		.listenForWhisper("callCancel", data => {
			this.callMe = false;
			this.stop('in')
		})
		.listenForWhisper('callAccept', data => {
			this.callAccepted = true;
			this.callFromMe = false;
			this.signal = data
			this.peer.signal(this.signal);
			this.stop('out')
		})
		.listenForWhisper("call", data => {
			this.callMe = true;
			this.signal = data
			this.play('in')
		});
	},
	methods: {
		stop(type){
			const target = type == 'in' ? this.audioIn : this.audioOut
			if(!target) return false
			target.currentTime = 0;
			target.pause();
		},
		play(type){
			if(type == 'in' && !this.audioIn){
				this.audioIn = new Audio('/sounds/in.mp3')
				this.audioIn.addEventListener('ended', function() {
					this.currentTime = 0;
					this.play();
				}, false);
			}else if(type == 'out' && !this.audioOut){
				this.audioOut = new Audio('/sounds/out.mp3')
				this.audioOut.addEventListener('ended', function() {
					this.currentTime = 0;
					this.play();
				}, false);
			}
			type == 'in' ? this.audioIn.play() : this.audioOut.play()
		},
		getMediaPermission() {
			return getPermissions()
			.then( stream => {
				this.stream = stream;
				if (this.$refs.userVideo) {
					this.$refs.userVideo.srcObject = stream;
				}
			})
			.catch((error) => {
				console.log(error);
			});
		},
		async callUser() {
			this.callFromMe = true;
			this.callPlaced = true;
			this.callDecline = false;
			this.play('out');
			await this.getMediaPermission();
			this.peer = new Peer({
				initiator: true,
				trickle: false,
				stream: this.stream,
				config: {
					iceServers: [
						{
							urls: this.turn_url,
							username: this.auth.name,
							credential: this.auth.id,
						},
					],
				},
			});

			this.peer.on("signal", data => {
				this.channel.whisper('call', data)
			});

			this.peer.on("stream", stream => {
				if (this.$refs.partnerVideo) {
					this.$refs.partnerVideo.srcObject = stream;
				}
			});
			this.peer.on("close", () => {
				this.callPlaced = false
				this.peer.destroy()
			});
		},

		async acceptCall() {
			this.callPlaced = true;
			this.callAccepted = true;
			this.callMe = false;
			this.stop('in');
			await this.getMediaPermission();
			this.peer = new Peer({
				initiator: false,
				trickle: false,
				stream: this.stream,
				config: {
					iceServers: [
						{
							urls: this.turn_url,
							username: this.auth.name,
							credential: this.auth.id,
						},
					],
				},
			});
			this.peer.on("signal", data => {
				this.channel.whisper('callAccept', data)
			});

			this.peer.on("stream", stream => {
				this.$refs.partnerVideo.srcObject = stream;
			});
			this.peer.on("close", () => {
				this.callPlaced = false
				this.peer.destroy()
			});
			this.peer.signal(this.signal);
		},
		toggleCameraArea() {
			if (this.callAccepted) {
				this.isFocusMyself = !this.isFocusMyself;
			}
		},
		declineCall() {
			this.callMe = false;
			this.stop('in');
			this.channel.whisper('callDecline')
		},

		toggleMuteAudio() {
			if (this.mutedAudio) {
				this.$refs.userVideo.srcObject.getAudioTracks()[0].enabled = true;
				this.mutedAudio = false;
			} else {
				this.$refs.userVideo.srcObject.getAudioTracks()[0].enabled = false;
				this.mutedAudio = true;
			}
		},

		toggleMuteVideo() {
			if (this.mutedVideo) {
				this.$refs.userVideo.srcObject.getVideoTracks()[0].enabled = true;
				this.mutedVideo = false;
			} else {
				this.$refs.userVideo.srcObject.getVideoTracks()[0].enabled = false;
				this.mutedVideo = true;
			}
		},

		stopStreamedVideo(videoElem) {
			const stream = videoElem.srcObject;
			const tracks = stream.getTracks();
			tracks.forEach((track) => {
				track.stop();
			});
			videoElem.srcObject = null;
		},
		endCall() {
			this.stop('out')
			if (!this.mutedVideo) this.toggleMuteVideo();
			if (!this.mutedAudio) this.toggleMuteAudio();
			this.stopStreamedVideo(this.$refs.userVideo);
			if (this.peer) this.peer.destroy();
			this.callPlaced = false;
			this.callFromMe = false
			this.channel.whisper('callCancel')
		},
	},
};
</script>

<style scoped>
#video-row {
  width: 700px;
  max-width: 90vw;
}

#incoming-call-card {
  border: 1px solid #0acf83;
}

.video-container {
  width: 700px;
  height: 500px;
  max-width: 90vw;
  max-height: 50vh;
  margin: 0 auto;
  border: 1px solid #0acf83;
  position: relative;
  box-shadow: 1px 1px 11px #9e9e9e;
  background-color: #fff;
}

.video-container .user-video {
  width: 30%;
  position: absolute;
  left: 10px;
  bottom: 10px;
  border: 1px solid #fff;
  border-radius: 6px;
  z-index: 2;
}

.video-container .partner-video {
  width: 100%;
  height: 100%;
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  top: 0;
  z-index: 1;
  margin: 0;
  padding: 0;
}

.video-container .action-btns {
  position: absolute;
  bottom: 20px;
  left: 50%;
  margin-left: -50px;
  z-index: 3;
  display: flex;
  flex-direction: row;
}

/* Mobiel Styles */
@media only screen and (max-width: 768px) {
  .video-container {
    height: 50vh;
  }
}
</style>