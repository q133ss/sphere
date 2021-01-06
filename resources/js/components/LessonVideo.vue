<template>
    <div>
        <div id="lesson-video-container" class="position-relative">
            <video id="localVideo" ref="localVideo" autoplay muted playsinline></video>
            <video id="remoteVideo" ref="remoteVideo" autoplay playsinline></video>
        </div>
        <button class="btn btn-primary btn-sm" @click="start" :disabled="status > 0">Начать</button>
        <button class="btn btn-success btn-sm" @click="call" :disabled="status != 1">Вызов</button>
        <button class="btn btn-danger btn-sm" @click="end" :disabled="status != 2">Сброс</button>
    </div>
</template>
<script>
export default {
    data(){
        return {
            status: 0,
            startTime: null,
            localStream: null,
            pc1: null,
            pc2: null,
            offerOptions: {
                offerToReceiveAudio: 1,
                offerToReceiveVideo: 1
            }
        }
    },
    mounted(){
        const localVideo = this.$refs.localVideo
        const remoteVideo = this.$refs.remoteVideo
        localVideo.addEventListener('loadedmetadata', function() {
            console.log('Local video videoWidth: ' + this.videoWidth + 'px,  videoHeight: ' + this.videoHeight + 'px');
        });
        remoteVideo.addEventListener('loadedmetadata', function() {
            console.log('Remote video videoWidth: ' + this.videoWidth + 'px,  videoHeight: ' + this.videoHeight + 'px');
        });
        remoteVideo.onresize = function() {
            console.log('Remote video size changed to ' + remoteVideo.videoWidth + 'x' + remoteVideo.videoHeight);
            if (this.startTime) {
                var elapsedTime = window.performance.now() - startTime;
                console.log('Setup time: ' + elapsedTime.toFixed(3) + 'ms');
                this.startTime = null;
            }
        };
    },
    methods: {
        start(){},
        call(){},
        end(){},
        getName(pc) { return (pc === this.pc1) ? 'pc1' : 'pc2' },
        getOtherPc(pc) { return (pc === this.pc1) ? this.pc2 : this.pc1 },
        gotStream(stream) {
            console.log('Received local stream')
            this.$refs.localVideo.srcObject = stream
            this.localStream = stream
            this.status = 1
        },
        start() {
            console.log('Requesting local stream')
            this.status = 1
            navigator.mediaDevices.getUserMedia({
                audio: true,
                video: true
            })
            .then(this.gotStream)
            .catch(function(e) { alert('Ошибка настройки оборудованния') });
        },
        call() {
            if(!this.localStream) return false
            this.status = 2
            console.log('Starting call')
            this.startTime = window.performance.now()
            var videoTracks = this.localStream.getVideoTracks()
            var audioTracks = this.localStream.getAudioTracks()
            if (videoTracks.length > 0) { console.log('Using video device: ' + videoTracks[0].label) }
            if (audioTracks.length > 0) { console.log('Using audio device: ' + audioTracks[0].label) }
            var servers = null
            this.pc1 = new RTCPeerConnection(servers)
            console.log('Created local peer connection object pc1')
            this.pc1.onicecandidate = e => {
                this.onIceCandidate(this.pc1, e)
            };
            this.pc2 = new RTCPeerConnection(servers)
            console.log('Created remote peer connection object pc2')
            this.pc2.onicecandidate = e => { this.onIceCandidate(this.pc2, e); }
            this.pc1.oniceconnectionstatechange = e => { this.onIceStateChange(this.pc1, e); }
            this.pc2.oniceconnectionstatechange = e => { this.onIceStateChange(this.pc2, e); }
            this.pc2.onaddstream = this.gotRemoteStream
            this.pc1.addStream(this.localStream)
            console.log('Added local stream to pc1')
            this.pc1.createOffer(this.offerOptions).then(
                this.onCreateOfferSuccess,
                this.onCreateSessionDescriptionError
            )
        },
        onCreateSessionDescriptionError(error) { console.log('Failed to create session description: ' + error.toString()) },
        onCreateOfferSuccess(desc) {
            console.log('pc1 setLocalDescription start')
            this.pc1.setLocalDescription(desc).then(
                () => { this.onSetLocalSuccess(this.pc1) },
                this.onSetSessionDescriptionError
            );
            console.log('pc2 setRemoteDescription start')
            this.pc2.setRemoteDescription(desc).then(
                () => { this.onSetRemoteSuccess(this.pc2) },
                this.onSetSessionDescriptionError
            );
            console.log('pc2 createAnswer start')
            this.pc2.createAnswer().then(
                this.onCreateAnswerSuccess,
                this.onCreateSessionDescriptionError
            )
        },
        onSetLocalSuccess(pc) {
            console.log(this.getName(pc) + ' setLocalDescription complete')
        },
        onSetRemoteSuccess(pc) {
            console.log(this.getName(pc) + ' setRemoteDescription complete')
        },
        onSetSessionDescriptionError(error) {
            console.log('Failed to set session description: ' + error.toString())
        },
        gotRemoteStream(e) {
            this.$refs.remoteVideo.srcObject = e.stream
            console.log('pc2 received remote stream')
        },
        onCreateAnswerSuccess(desc) {
            console.log('Answer from pc2:\n' + desc.sdp)
            console.log('pc2 setLocalDescription start')
            this.pc2.setLocalDescription(desc).then(
                () => { this.onSetLocalSuccess(this.pc2) },
                this.onSetSessionDescriptionError
            )
            console.log('pc1 setRemoteDescription start');
            this.pc1.setRemoteDescription(desc).then(
                () => { this.onSetRemoteSuccess(this.pc1) },
                this.onSetSessionDescriptionError
            )
        },
        onIceCandidate(pc, event) {
            this.getOtherPc(pc).addIceCandidate(event.candidate)
            .then(
                () => { this.onAddIceCandidateSuccess(pc) },
                err => { this.onAddIceCandidateError(pc, err) }
            )
            console.log(this.getName(pc) + ' ICE candidate: \n' + (event.candidate ? event.candidate.candidate : '(null)'))
        },
        onAddIceCandidateSuccess(pc) { console.log(this.getName(pc) + ' addIceCandidate success') },
        onAddIceCandidateError(pc, error) { console.log(this.getName(pc) + ' failed to add ICE Candidate: ' + error.toString()) },
        onIceStateChange(pc, event) {
            if (pc) {
                console.log(this.getName(pc) + ' ICE state: ' + pc.iceConnectionState);
                console.log('ICE state change event: ', event)
            }
        },
        end() {
            console.log('Ending call');
            this.pc1.close()
            this.pc2.close()
            this.pc1 = null
            this.pc2 = null
            this.status = 1
        }
    }
}
</script>
<style>
    #lesson-video-container{
        height: 100%;
        min-height: 300px;
    }
    #remoteVideo{
        position: absolute;
        display: block;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    #localVideo{
        display: block;
        width: 30%;
        height: 30%;
        position: absolute;
        bottom: 20px;
        left: 20px;
        z-index: 2;
        border: 1px solid #ddd;
    }
</style>