
<script src="<?=base_url()?>assets/vendor/libs/jquery/jquery.js"></script>
<script src="<?=base_url()?>assets/vendor/libs/popper/popper.js"></script>
<script src="<?=base_url()?>assets/vendor/js/bootstrap.js"></script>
<script src="<?=base_url()?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?=base_url()?>assets/vendor/js/menu.js"></script>
<script src="<?=base_url()?>assets/js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.5/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script> -->
</head>
<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>

<script type="text/javascript">

let selectedDeviceId = null;
const codeReader = new ZXing.BrowserMultiFormatReader();
const sourceSelect = $("#pilihKamera");
const form = {
    assetId: null
}

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function initScanner() {
    codeReader
    .listVideoInputDevices()
    .then(videoInputDevices => {
        // videoInputDevices.forEach(device =>
        //     console.log(`${device.label}, ${device.deviceId}`)
        // );

        if (videoInputDevices.length > 0) {

            // Access first access for initial
            if (selectedDeviceId == null){
                selectedDeviceId = videoInputDevices[0].deviceId;
                // selectedDeviceId = videoInputDevices[4].deviceId;
            }
            
            // Show camera option 
            sourceSelect.html('');
            videoInputDevices.forEach((element) => {
                const sourceOption = document.createElement('option')
                sourceOption.text = element.label
                sourceOption.value = element.deviceId
                if(element.deviceId == selectedDeviceId){
                    sourceOption.selected = 'selected';
                }
                sourceSelect.append(sourceOption)
            })

            // Read QRCode and display text result
            codeReader
                .decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
                .then(result => {

                    console.log(result);

                    const videoElement = document.getElementById('previewKamera');
                    const imgElement = document.getElementById('resultImg');
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');

                    function captureFrame() {
                        canvas.width = videoElement.videoWidth;
                        canvas.height = videoElement.videoHeight;

                        context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
                        // context.drawImage(videoElement, 0, 0);
                        return canvas.toDataURL(); // Convert canvas to data URL
                    }

                    const imageDataUrl = captureFrame();
                    imgElement.src = imageDataUrl;

                    $('#resultAssetId').text(result.text);

                    form.assetId = result.text;
                    // console.log(form.assetId, "sdasda")
                    getUjiMaterial(form.assetId);
                    
                    $('.camp').hide();
                    if (codeReader){
                        codeReader.reset();
                    }

                })
                .catch(err => {
                    if (err.message == 'Could not start video source') {
                        let deviceName = $('#pilihKamera').find(":selected").text();
                        console.error(err, `Cannot access ${deviceName}`);
                        alert(`Cannot access ${deviceName}`);
                    }
                });
                
        } else {
            alert("Camera not found!")
        }
    })
    .catch(err => console.error(err));
}


function getUjiMaterial(assetId) {
    // console.log(assetId, "2")
    $.ajax({
        url : "<?=base_url()?>index.php/scan_aset/getUjiMaterial/",
        type: "GET",
        dataType:"JSON",
        data: {
            assetId: assetId
        },
        success: function(data){
            resetContent();
            console.log(data);
            if (data.meta.code == 404) {
                Toast.fire({
                    icon: 'error',
                    // title: "Data tidak ditemukan"
                    title: data.meta.message
                })
            } else {
                // Toast.fire({
                //     icon: 'success',
                //     title: "Data ditemukan!!!"
                // })
                // setContent(data);
                setContent(data.data);
            }   
        }
    });
}

function resetContent() {
    $('.content').html('');
}

function setContent(data) {
    let content = '<div class="p-1 m-3">';
    content += `
    <h5>Detail Data</h5>\
    <table>\
        <tbody>\
            <tr class="table-font-weight-bold">\
                <td style="vertical-align: top;">ASSET ID</td>\
                <td><span class="asset_id">${data.asset.asset_id}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">Nama Aset</td>\
                <td> : <span class="name_asset">${data.asset.name_asset}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">Kode Lokasi</td>\
                <td> : <span class="kode_location">${data.asset.kode_location}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">Nama Lokasi</td>\
                <td> : <span class="location_asset">${data.asset.location_asset}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">No Kontrak</td>\
                <td> : <span class="no_kontrak">${data.asset.no_kontrak}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">Nama Proyek</td>\
                <td> : <span class="name_project">${data.asset.name_project}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">Tahun Proyek</td>\
                <td> : <span class="year_proyek">${data.asset.year_project}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">Nilai Proyek</td>\
                <td> : <span class="price">${formatPriceToIDR(data.asset.price)}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">PPK</td>\
                <td> : <span class="ppk_user">${data.asset.ppk_user}</span></td>\
            </tr>\
            <tr>\
                <td class="table-font-weight-bold" style="vertical-align: top;">Nama Vendor</td>\
                <td> : <span class="name_vendor">${data.asset.name_vendor}</span></td>\
            </tr>\
        </tbody>\
    </table>\
    `

    content += `
    <h5 class="mt-3">Spek Tek</h5>\
    <table class="table table-striped table-bordered mt-3">\
        <thead>\
        </thead>\
        <tbody class="list-data">\
    `
    const spekTek = data.asset.product_attribute
    for (let i in spekTek) {
        content += `
            <tr>\
                <td class="table-font-weight-bold">${spekTek[i].name}</td>\
                <td>${spekTek[i].description}</td>\
            </tr>\
        `
    }
    content += `
        </tbody>\
    </table>\
    `

    content += `
    <h5 class="mt-3">History</h5>\
    <table class="table table-striped table-bordered mt-3">\
        <thead>\
            <tr class="table-font-weight-bold">\
                <td>Dari</td>\
                <td>Ke</td>\
                <td>Tanggal / Jam</td>\
            </tr>\
        </thead>\
        <tbody class="list-data-history">\
    `
    const history = data.history
    for (let i in history) {
        content += `
            <tr>\
                <td>${history[i].location_awal}</td>\
                <td>${history[i].location_tujuan}</td>\
                <td>${formatDate(history[i].tanggal)}</td>\
            </tr>\
        `
    }
    content += `
        </tbody>\
    </table>\
    `

    content += `</div>`
    $('.content').append(content);
}

function formatPriceToIDR(value) {
    if (!value) return value;

    // Convert the value to a string
    let valueStr = String(value);

    if (valueStr.length <= 3) return 'Rp'+valueStr
        
    // Determine the position to start inserting dots
    let startPos = valueStr.length % 3;

    // Insert dots every three characters
    let result = valueStr.slice(0, startPos) + '.' + valueStr.slice(startPos).match(/\d{3}/g).join('.');

    if (result[0] == '.') {
        result = result.substr(1)
    }

    return 'Rp'+result;
}

function formatDate(value) {
    if (!value) return value;

    let valueStr = String(value);
    return valueStr.split('.')[0]
}

$(document).ready(function() {
    $('.camp').show();
});

$(document).on('change','#pilihKamera',function(){
    selectedDeviceId = $(this).val();
    if (codeReader){
        codeReader.reset();
        initScanner();
    }
})

$(document).on('click','#resetScan',function(){
    if(codeReader){
        codeReader.reset();
        $('.camp').show();
        initScanner();
        resetContent();

        form.assetId = null;

        // <img id="resultImg" src="" alt="" style="max-width: 93.5%; max-height: 93.5%;"/>
        const imgElement = document.getElementById('resultImg');
        imgElement.src = null;

        $('#resultAssetId').text('');
    }
})

if (navigator.mediaDevices) {
    initScanner();
} else {
    alert('Cannot access camera.');
}


</script>
