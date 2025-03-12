<main>

<div class="container">
    <div class="row">
      <div class="col-12">
        <form>
          <label for="ticketNumber">Ticket Number:</label>
          <input type="text" id="ticketNumber" name="ticketNumber" readonly><br><br>
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
      const ticketNumberInput = document.getElementById('ticketNumber');
      const ticketForm = document.getElementById('ticketForm');
      const correctCodes = <?php echo json_encode($correctCodes); ?>;
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
        for (let i = 0; i < correctCodes.length; i++) {
          const decodedString = atob(content);
          ticketNumberInput.value = decodedString;
          if (parseInt(decodedString) == correctCodes[i].invoice_id) {
            if (correctCodes[i].isScanned == 1) {
              scannedImage.style.display = 'block';
              correctImage.style.display = 'none';
              incorrectImage.style.display = 'none';
              return;
            }
            else {
              correctImage.style.display = 'block';
              incorrectImage.style.display = 'none';
              scannedImage.style.display = 'none';
              fetch('/qrscanner?invoice_id=' + decodedString,{
                method: 'POST',
              });
            }
          } else {
            console.log(parseInt(decodedString), correctCodes[i].invoice_id);

            correctImage.style.display = 'none';
            scannedImage.style.display = 'none';
            incorrectImage.style.display = 'block';
          }
        }
      });
    </script>
</div>

</main>