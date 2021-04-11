$(() => {
    // initialize responsive datatable
    $.initBasicTable('#dt_basic')
    const $table = $('#dt_basic').DataTable();
    $table.columns(0)
        .order('asc')
        .draw()

    // Fungsi cari
    $('#nama').select2({
        minimumInputLength: 1,
        ajax: {
            method: 'post',
            url: '<?= base_url() ?>perizinan/izin/cari',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term
                }
            }
        }
    })

    const addRow = (data) => {
        let row = [
            data.nama,
            data.keterangan,
            data.tanggal_izin,
            data.tanggal_selesai,
            data.status,
            `
            <div id="btn-ubah-${data.id}">
            <button class="btn btn-primary btn-sm" onclick="Ubah(${data.id})">
                <i class="fa fa-edit"></i> Ubah
            </button>
            <button class="btn btn-danger btn-sm" onclick="Hapus(${data.id})">
                <i class="fa fa-trash"></i> Hapus
            </button>
            </div>
            `
        ]

        let $node = $($table.row.add(row).draw().node())
        $node.attr('data-id', data.id)
    }

    // Edit Row
    const editRow = (id, data) => {
        let row = $table.row('[data-id=' + id + ']').index();

        $($table.row(row).node()).attr('data-id', id);
        $table.cell(row, 0).data(data.nama);
        let btn = $(`#btn-ubah-${data.id}`);
        btn.html(`
        <div id="btn-ubah-${data.id}">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUbah" data-id="${data.id}" data-nama="${data.nama}" onclick="Ubah(this)">
            <i class="fa fa-edit"></i> Ubah
        </button>
        <button class="btn btn-danger btn-sm" onclick="Hapus(${data.id})">
            <i class="fa fa-trash"></i> Hapus
        </button>
        </div>
        `);
    }

    // Delete Row
    const deleteRow = (id) => {
        $table.row('[data-id=' + id + ']').remove().draw()
    }

    // Fungsi simpan tambah
    $('#form-tambah').submit((ev) => {
        ev.preventDefault();

        let nama = $("#nama").val();
        if (nama) {
            let id_santri = nama[0];
            let tanggal_izin = $('#tanggal_izin').val();
            let tanggal_selesai = $('#tanggal_selesai').val();
            let keterangan = $('#keterangan').val();
            window.apiClient.perizinanIzin.insert(id_santri, tanggal_izin, tanggal_selesai, keterangan)
                .done((data) => {
                    $.doneMessage('Berhasil ditambahkan.', 'Perizinan Santri')
                    addRow(data)

                })
                .fail(($xhr) => {
                    $.failMessage('Gagal ditambahkan. data mungkin sudah ada.', 'Perizinan Santri')
                }).
                always(() => {
                    $('#modalTambah').modal('toggle')
                })
        } else {
            $.failMessage('Gagal ditambahkan. Nama santri belum ditentukan', 'Perizinan Santri')
        }

    })


    // validasi nama
    $('#nama').on('change', function () {
        if (this.value) {
            $('#tanggal_selesai').attr("disabled", false);
            $('#tanggal_izin').attr("disabled", false);
            $('#keterangan').attr("disabled", false);
        } else {
            $('#tanggal_selesai').attr("disabled", true);
            $('#tanggal_izin').attr("disabled", true);
            $('#keterangan').attr("disabled", true);

        }
    })


    // Fungsi Update
    $('#form-ubah').submit((ev) => {
        ev.preventDefault();

        let nama = $("#nama-ubah").val();
        let id = $("#id-ubah").val();

        window.apiClient.santriRuang.update(id, nama)
            .done((data) => {
                $.doneMessage('Berhasil diubah.', 'Santri Ruang')
                editRow(id, data)

            })
            .fail(($xhr) => {
                $.failMessage('Gagal diubah. data mungkin sudah ada.', 'Santri Ruang')
            }).
            always(() => {
                $('#modalUbah').modal('toggle')
            })
    })

    // Fungsi Delete
    $('#OkCheck').click(() => {

        let id = $("#idCheck").val()
        window.apiClient.santriRuang.delete(id)
            .done((data) => {
                $.doneMessage('Berhasil dihapus.', 'Santri Ruang')
                deleteRow(id)

            })
            .fail(($xhr) => {
                $.failMessage('Gagal dihapus.', 'Santri Ruang')
            }).
            always(() => {
                $('#ModalCheck').modal('toggle')
            })
    })
})

// Click Hapus
const Hapus = (id) => {
    $("#idCheck").val(id)
    $("#LabelCheck").text('Hapus Ruang Santri')
    $("#ContentCheck").text('Apakah anda yakin akan menghapus data ini?')
    $('#ModalCheck').modal('toggle')
}

// Click Ubah
const Ubah = (data) => {
    $("#id-ubah").val(data.dataset.id);
    $("#nama-ubah").val(data.dataset.nama);
}