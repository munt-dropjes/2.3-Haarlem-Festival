<main>

<div class="container">
    <div class="row">
      <div class="col-12">
        <form>
          <label for="ticket">Ticket Number:</label>
          <input type="text" id="ticket" name="ticket"><br><br>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <video id="preview"></video>
      </div>
    </div>
    <div class="row">
      <div class="col-6 text-center" id="correctImage">
        <img src="img/icons/correct.png" alt="Correct">
        <p>The qr code is scanned</p>
      </div>
      <div class="col-6 text-center" id="incorrectImage">
        <img src="img/icons/incorrect.png" alt="Incorrect">
        <p>The qr code is incorrect</p>
      </div>
      <div class="col-6 text-center" id="scannedImage">
        <img src="img/icons/alreadyScanned.png" alt="Scanned">
        <p>The qr code has already been scanned</p>
      </div>
    </div>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>

    <script>
      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      let correctImage = document.getElementById('correctImage');
      let incorrectImage = document.getElementById('incorrectImage');
      let scannedImage = document.getElementById('scannedImage');
      const ticket = document.getElementById('ticket');

      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
          document.getElementById('preview').style.display = 'block';
        } else {
          console.error('No cameras found.');
        } 
      }).catch(function (e) {
        console.error(e);
      });
      
      scanner.addListener('scan', function (content) {
        console.log("scanning");
        const decodedString = atob(content);
        console.log("decodedstring: " decodedString);

        qrservice.checkTicket(decodedString).then(function (response) {
          if (response.status === 200) {
            if (response.data.status === 'correct') {
              correctImage.style.display = 'block';
              incorrectImage.style.display = 'none';
              scannedImage.style.display = 'none';
            } else if (response.data.status === 'incorrect') {
              correctImage.style.display = 'none';
              incorrectImage.style.display = 'block';
              scannedImage.style.display = 'none';
            } else if (response.data.status === 'scanned') {
              correctImage.style.display = 'none';
              incorrectImage.style.display = 'none';
              scannedImage.style.display = 'block';
            }
          } else {
            console.error('Error: ', response.statusText);
          }
        }).catch(function (error) {
          console.error('Error: ', error);
        });
      });
    </script>
</div>

</main>