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
        <button type="button" class="btn btn-sm btn-success" v-for="user in allusers" :key="user.id" @click="placeVideoCall(user.id, user.name)"><i class="fa fa-volume-control-phone"></i> {{ user.name }} <span class="badge badge-light">{{getUserOnlineStatus(user.id)}}</span></button>
      </div>
    </div>
  </div>
  <div class="card-body p-1">
    <div id="lesson-video-container" class="position-relative">
      <div v-if="callPlaced">
        <video id="localVideo" ref="userVideo" muted playsinline autoplay class="cursor-pointer" :class="isFocusMyself === true ? 'user-video' : 'partner-video'" @click="toggleCameraArea"/>
        <video id="remoteVideo" ref="partnerVideo" playsinline autoplay class="cursor-pointer" :class="isFocusMyself === true ? 'partner-video' : 'user-video'" @click="toggleCameraArea" v-if="videoCallParams.callAccepted" />
      </div>
      <div class="partner-video" v-else>
        <div v-if="callPartner" class="column items-center q-pt-xl">
          <div class="col q-gutter-y-md text-center">
            <p class="q-pt-md"><strong>{{ callPartner }}</strong></p>
            <p>Идет вызов...</p>
          </div>
        </div>
      </div>
      <div class="text-center" v-if="incomingCallDialog">
        <p>Входящий вызов от <strong>{{ callerDetails.name }}</strong></p>
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
  props: [
    "allusers",
    "authuserid",
    // "turn_url",
    "turn_username",
    "turn_credential",
  ],
  data() {
    return {
      turn_url: [
        'stun:stun.l.google.com:19302',
        'stun:global.stun.twilio.com:3478'
      ],
      isFocusMyself: true,
      callPlaced: false,
      callPartner: null,
      mutedAudio: false,
      mutedVideo: false,
      videoCallParams: {
        users: [],
        stream: null,
        receivingCall: false,
        caller: null,
        callerSignal: null,
        callAccepted: false,
        channel: null,
        peer1: null,
        peer2: null,
      },
    };
  },

  mounted() {
    this.initializeChannel(); // this initializes laravel echo
    this.initializeCallListeners(); // subscribes to video presence channel and listens to video events
  },
  computed: {
    incomingCallDialog() {
      return this.videoCallParams.receivingCall && this.videoCallParams.caller !== this.authuserid
    },
    callerDetails() {
      if (
        this.videoCallParams.caller &&
        this.videoCallParams.caller !== this.authuserid
      ) {
        const incomingCaller = this.allusers.filter(
          (user) => user.id === this.videoCallParams.caller
        );

        return {
          id: this.videoCallParams.caller,
          name: `${incomingCaller[0].name}`,
        };
      }
      return null;
    },
  },
  methods: {
    initializeChannel() {
      this.videoCallParams.channel = window.Echo.join("presence-video-channel");
    },

    getMediaPermission() {
      return getPermissions()
        .then((stream) => {
          this.videoCallParams.stream = stream;
          if (this.$refs.userVideo) {
            this.$refs.userVideo.srcObject = stream;
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    initializeCallListeners() {
      this.videoCallParams.channel.here((users) => {
        this.videoCallParams.users = users;
      });

      this.videoCallParams.channel.joining((user) => {
        // check user availability
        this.$toast.success(user.name + ' присоединился к уроку')
        const joiningUserIndex = this.videoCallParams.users.findIndex(
          (data) => data.id === user.id
        );
        if (joiningUserIndex < 0) {
          this.videoCallParams.users.push(user);
        }
      });

      this.videoCallParams.channel.leaving((user) => {
        this.$toast.warning(user.name + ' покинул урок')
        const leavingUserIndex = this.videoCallParams.users.findIndex(
          (data) => data.id === user.id
        );
        this.videoCallParams.users.splice(leavingUserIndex, 1);
      });
      // listen to incomming call
      this.videoCallParams.channel.listen("StartVideoChat", ({ data }) => {
        if (data.type === "incomingCall") {
          // add a new line to the sdp to take care of error
          const updatedSignal = {
            ...data.signalData,
            sdp: `${data.signalData.sdp}\n`,
          };

          this.videoCallParams.receivingCall = true;
          this.videoCallParams.caller = data.from;
          this.videoCallParams.callerSignal = updatedSignal;
        }
      });
    },
    async placeVideoCall(id, name) {
      this.callPlaced = true;
      this.callPartner = name;
      await this.getMediaPermission();
      this.videoCallParams.peer1 = new Peer({
        initiator: true,
        trickle: false,
        stream: this.videoCallParams.stream,
        config: {
          iceServers: [
            {
              urls: this.turn_url,
              username: this.turn_username,
              credential: this.turn_credential,
            },
          ],
        },
      });

      this.videoCallParams.peer1.on("signal", (data) => {
        // send user call signal
        axios
          .post("/video/call-user", {
            user_to_call: id,
            signal_data: data,
            from: this.authuserid,
          })
          .then(() => {})
          .catch((error) => {
            console.log(error);
          });
      });

      this.videoCallParams.peer1.on("stream", (stream) => {
        console.log("call streaming");
        if (this.$refs.partnerVideo) {
          this.$refs.partnerVideo.srcObject = stream;
        }
      });

      this.videoCallParams.peer1.on("connect", () => {
        console.log("peer connected");
      });

      this.videoCallParams.peer1.on("error", (err) => {
        console.log(err);
      });

      this.videoCallParams.peer1.on("close", () => {
        console.log("call closed caller");
      });

      this.videoCallParams.channel.listen("StartVideoChat", ({ data }) => {
        if (data.type === "callAccepted") {
          if (data.signal.renegotiate) {
            console.log("renegotating");
          }
          if (data.signal.sdp) {
            this.videoCallParams.callAccepted = true;
            const updatedSignal = {
              ...data.signal,
              sdp: `${data.signal.sdp}\n`,
            };
            this.videoCallParams.peer1.signal(updatedSignal);
          }
        }
      });
    },

    async acceptCall() {
      this.callPlaced = true;
      this.videoCallParams.callAccepted = true;
      await this.getMediaPermission();
      this.videoCallParams.peer2 = new Peer({
        initiator: false,
        trickle: false,
        stream: this.videoCallParams.stream,
        config: {
          iceServers: [
            {
              urls: this.turn_url,
              username: this.turn_username,
              credential: this.turn_credential,
            },
          ],
        },
      });
      this.videoCallParams.receivingCall = false;
      this.videoCallParams.peer2.on("signal", (data) => {
        axios
          .post("/video/accept-call", {
            signal: data,
            to: this.videoCallParams.caller,
          })
          .then(() => {})
          .catch((error) => {
            console.log(error);
          });
      });

      this.videoCallParams.peer2.on("stream", (stream) => {
        this.videoCallParams.callAccepted = true;
        this.$refs.partnerVideo.srcObject = stream;
      });

      this.videoCallParams.peer2.on("connect", () => {
        console.log("peer connected");
        this.videoCallParams.callAccepted = true;
      });

      this.videoCallParams.peer2.on("error", (err) => {
        console.log(err);
      });

      this.videoCallParams.peer2.on("close", () => {
        console.log("call closed accepter");
      });

      this.videoCallParams.peer2.signal(this.videoCallParams.callerSignal);
    },
    toggleCameraArea() {
      if (this.videoCallParams.callAccepted) {
        this.isFocusMyself = !this.isFocusMyself;
      }
    },
    getUserOnlineStatus(id) {
      const onlineUserIndex = this.videoCallParams.users.findIndex(
        (data) => data.id === id
      );
      if (onlineUserIndex < 0) {
        return "Не в сети";
      }
      return "В сети";
    },
    declineCall() {
      this.videoCallParams.receivingCall = false;
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
      // if video or audio is muted, enable it so that the stopStreamedVideo method will work
      if (!this.mutedVideo) this.toggleMuteVideo();
      if (!this.mutedAudio) this.toggleMuteAudio();
      this.stopStreamedVideo(this.$refs.userVideo);
      if (this.authuserid === this.videoCallParams.caller) {
        this.videoCallParams.peer1.destroy();
      } else {
        this.videoCallParams.peer2.destroy();
      }
      this.videoCallParams.channel.pusher.channels.channels[
        "presence-presence-video-channel"
      ].disconnect();

      setTimeout(() => {
        this.callPlaced = false;
      }, 3000);
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