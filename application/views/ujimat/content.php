
<div class="row">
    <div class="col-md-12 mt-1">
        <div class="form-group">
            <select class="form-control kontrak">
                <option value="">-- Semua Kontrak --</option>
            </select>
            <input type="hidden" class="kontrak-data">
        </div>    
    </div>
    <div class="col-md-12 mt-2">
        <select class="default-select sipb" style="width:100%;" name="SIPB">
        </select>
    </div>

    <div class="col-md-12 mb-2 camp text-center visible">
        <div class="p-2 m-3">
            <video id="previewKamera" style="width: 100%;"></video>
        </div>
        <br>
        <label class="form-label">Pilih Kamera</label>
        <select id="pilihKamera" class="form-control pilihKamera">
        </select>
    </div>

    <div class="col-md-12 mt-2">
        <a hre="javascript:void(0)" class="btn btn-primary btm-lg" style="color:white; width:100%;" onclick="scanQrcode(1)">Scan Qrcode</a>
    </div>

    <div class="col-6">
        <div class="form-group mt-2">
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="">
            <table class="table table-striped table-bordered mt-3" style="font-size:10px;" id="myTable">
            <input name="nomer" type="hidden" value="0">
            <thead style="background-color:#342a29;">
                <tr>
                    <th style="color:white;"><input type="checkbox" id="checkAll"></th>
                    <th style="color:white;">ID Aset</th>
                    <th style="color:white;">Nama</th>
                </tr>
            </thead>
            <tbody class="listtable">
            </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-ujimat" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
    <div class="modal-content ">
        <div class="modal-header">
            <h5 class="modal-title" id="modalLongTitle">Scan RFID</h5>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
        </button>
        </div>
    </div>
    </div>
</div>


<div class="modal fade" id="modalLong" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" role="document">
    <div class="modal-content ">
        <div class="modal-header">
            <h5 class="modal-title" id="modalLongTitle">Detail RFID</h5>
        </div>
        <div class="modal-body">
        <table>
            <tbody>
                <tr>
                    <td>ASSET ID</td>
                    <td><span class="asset_id"></span></td>
                </tr>
                <tr>
                    <td>Nama Aset</td>
                    <td> : <span class="name_asset"></span></td>
                </tr>
                <tr>
                    <td>Serial Number</td>
                    <td> : <span class="serial_number"></span></td>
                </tr>
                <tr>
                    <td>PPK</td>
                    <td> : <span class="ppk_user"></span></td>
                </tr>
                <tr>
                    <td>Proyek</td>
                    <td> : <span class="name_project"></span></td>
                </tr>
                <tr>
                    <td>Tahun Project</td>
                    <td> : <span class="year_project"></span></td>
                </tr>
            </tbody>
        </table>

        <table class="table table-striped table-bordered mt-3">
            <thead>
            </thead>
            <tbody class="list-data">
            </tbody>
        </table>

        <h5>History</h5>

        <table class="table table-striped table-bordered mt-3">
            <thead>
                <tr>
                    <td>Dari</td>
                    <td>Ke</td>
                    <td>Tanggal / Jam</td>
                </tr>
            </thead>
            <tbody class="list-data-history">
            </tbody>
        </table>

        </div>
        <div class="modal-footer">
        <button type="button" onclick="closeMat()" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
        </button>
        </div>
    </div>
    </div>
</div>
