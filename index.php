<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <title>ESIG Student Check</title>
    <style>
        .row {
            display: flex;
        }
    </style>

</head>


<body>
    <script src="html5-qrcode.min.js"></script>
    
    <div class="jumbotron h-100 bg-primary" style="padding: 50px; margin: 60px; position:relative">
        <div class="row">
            <div class="card bg-light">
                <div class="" style="margin-left:130px; margin-right:130px; margin-top: 20px; margin-bottom: 20px; position:absolute" id="reader"></div>
            </div>
            
            <div class="" style="padding:30px;">
                <h1>ESIG Student Check</h1>
                <p>Semaine de professionalisation 2021 - 2022</p>
            </div>
        </div>
        
    </div>

    <script src="jquery/jquery-2.2.4.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script type="text/javascript">

        var data
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "http://127.0.0.1/student-check/students", true)

        xhr.onreadystatechange = function () {
            if(this.readyState === this.DONE && this.status === 200) {
                data = JSON.parse(this.response)
                console.log(data) // pour vérifier si les données du fichier Excel sont bien transmises
            }
        }
        xhr.send()

        function onScanSuccess(qrCodeMessage) {
            
            qrCodeMessage = JSON.parse(qrCodeMessage);
            // console.log(qrCodeMessage); // pour vérifier si les données sont bien décodées du code QR
            var found = false;
            var cible = 0;
            var i = 0;
            while (i < data.length && found == false) {
                
                if (qrCodeMessage.matricule == data[i].matricule && qrCodeMessage.nom == data[i].nom && qrCodeMessage.prenom == data[i].prenom && qrCodeMessage.filiere == data[i].filiere && qrCodeMessage.annee == data[i].annee) {
                    found = true
                    cible = data[i];
                } else {
                    found = false
                }
                i++;
            }

            if (found == true) {
                if (cible.aj) {
                    Swal.fire({
                    title: 'À jour !',
                    text: "L'étudiant "+cible.nom+' ' + cible.prenom+' est en règle !',
                    icon: 'success',
                    confirmButtonText: 'OK'
                    })
                } else {
                    Swal.fire({
                    title: 'Pas à jour !',
                    text: "L'étudiant "+cible.nom+' ' + cible.prenom+" n'est pas en règle !",
                    icon: 'warning',
                    confirmButtonText: 'OK'
                    })
                }
            } else {
                Swal.fire({
                    title: 'Pas de correspondance !',
                    text: 'Revérifiez vos informations ou inscrivez-vous !',
                    icon: 'error',
                    confirmButtonText: 'Réessayer'
                })
            }

            
        }
        // await new Promise(resolve => setTimeout(onScanSuccess, 3000)); //execute onScanSuccess after 5000 milliseconds (5 seconds)

        function onScanError(errorMessage) {
            //handle scan error
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>

</body>
</html>






