function createPlayer(width, height, streamControl) {
  var player = new Player({
    useWorker: true,
    workerFile: "broadway/Decoder.js",
    reuseMemory: true,
    webgl: "auto",
    size: {
      width: width,
      height: height,
    }
  });

  var frameCount = 0
  player.onPictureDecoded = function(data) {
    if (frameCount == 0) {
      console.log("First frame decoded");
    }
    frameCount++;
  };

  var container = document.getElementById("container");

  var cropDiv = document.createElement("div");
  cropDiv.style.overflow = "hidden";
  cropDiv.style.position = "absolute";
  cropDiv.style.width = width + "px";
  cropDiv.style.height = height + "px";
  cropDiv.appendChild(player.canvas);
  container.appendChild(cropDiv);

  var canvas = document.createElement("canvas");
  canvas.id = "overlay"
  canvas.style.position = "absolute";
  canvas.width = width;
  canvas.height = height;
  container.appendChild(canvas);

  return player
}

window.onload = function() {
  protobuf.load("messages.proto", function(err, root) {
    if (err)
      throw err;

    var ClientBound = root.lookupType("ClientBound");
    var ServerBound = root.lookupType("ServerBound")

    function streamControl(enabled) {
        serverBound = ServerBound.create({streamControl: {enabled:enabled}});
        socket.send(ServerBound.encode(serverBound).finish());
    }

    var player = null;
    var socket = new WebSocket("ws://" + window.location.host + "/stream");
    socket.binaryType = "arraybuffer";

    socket.onopen = function(event) {
      console.log("Socket connected.");
      streamControl(true);
    };

    socket.onclose = function(event) {
      console.log("Socket closed.");
    };

    socket.onmessage = function(event) {
      var clientBound = ClientBound.decode(new Uint8Array(event.data))
      switch (clientBound.message) {
        case 'start':
          console.log('Starting...')
          start = clientBound.start;
          if (player == null) {
            console.log('Starting...')
            player = createPlayer(start.width, start.height, streamControl);
            console.log("Started: " + start.width + "x" + start.height);
          }
          break;
        case 'video':
          player.decode(clientBound.video.data);
          break;
        case 'overlay':
          var canvas = document.getElementById("overlay");
          var ctx = canvas.getContext("2d");
          var img = new Image();
          img.onload = function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
          }
          img.src = "data:image/svg+xml;charset=utf-8," + clientBound.overlay.svg;
          break;
        case 'stop':
          console.log("Stopped.");
          break;
      }
    };
  });
};
