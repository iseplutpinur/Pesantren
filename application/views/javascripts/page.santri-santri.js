$(() => {
    // initialize responsive datatable
    $.initBasicTable('#dt_basic')
    const $table = $('#dt_basic').DataTable()
    $table.columns(0)
        .order('asc')
        .draw()

    // Add Row
    const addRow = (data) => {
        let row = [
            data.parent,
            data.nama,
            data.keterangan,
            data.index,
            '<i class="' + data.icon + '"></i> ' + data.icon,
            data.url,
            data.status,
            '<div>'
            + '<button class="btn btn-primary btn-sm" onclick="Ubah(' + data.id + ')"><i class="fa fa-edit"></i> Ubah</button>'
            + '<button class="btn btn-danger btn-sm" onclick="Hapus(' + data.id + ')"><i class="fa fa-trash"></i> Hapus</button>'
            + '</div>'
        ]

        let $node = $($table.row.add(row).draw().node())
        $node.attr('data-id', data.id)
    }

    // Edit Row
    const editRow = (id, data) => {
        let row = $table.row('[data-id=' + id + ']').index()

        $($table.row(row).node()).attr('data-id', id)
        $table.cell(row, 0).data(data.parent)
        $table.cell(row, 1).data(data.nama)
        $table.cell(row, 2).data(data.keterangan)
        $table.cell(row, 3).data(data.index)
        $table.cell(row, 4).data('<i class="' + data.icon + '"></i> ' + data.icon)
        $table.cell(row, 5).data(data.url)
        $table.cell(row, 6).data(data.status)
    }

    // Delete Row
    const deleteRow = (id) => {
        $table.row('[data-id=' + id + ']').remove().draw()
    }





    // Fungsi simpan
    $('#form-tambah').submit((ev) => {
        ev.preventDefault();
        let tingkat_id = $("#tingkat").val();
        let kelas_id = $("#kelas").val();
        let ruang_id = $("#ruang").val();
        let tahun_ajaran_id = $("#tahun_ajaran").val();
        let nama = $("#nama").val();
        let jenis_kelamin = $("#jenis_kelamin").val();
        let alamat = $("#alamat_lengkap").val();
        let status = $("#status").val();
        let tanggal_lahir = $("#tanggal_lahir").val();
        let no_hp = $("#no_telepon").val();

        window.apiClient.santriSantri.insert(tingkat_id, kelas_id, ruang_id, tahun_ajaran_id, nama, jenis_kelamin, alamat, status, tanggal_lahir, no_hp)
            .done((data) => {
                $.doneMessage('Berhasil ditambahkan.', 'Santri Santri')
                addRow(data)

            })
            .fail(($xhr) => {
                $.failMessage('Gagal ditambahkan.', 'Santri Santri')
            }).
            always(() => {
                $('#myModal').modal('toggle')
            })


        // if (id == 0) {

        //     // Insert

        // }
        // else {

        //     // Update

        //     window.apiClient.santriSantri.update(id, menu_menu_id, nama, index, icon, url, keterangan, status)
        //         .done((data) => {
        //             $.doneMessage('Berhasil diubah.', 'Santri Santri')
        //             editRow(id, data)

        //         })
        //         .fail(($xhr) => {
        //             $.failMessage('Gagal diubah.', 'Santri Santri')
        //         }).
        //         always(() => {
        //             $('#myModal').modal('toggle')
        //         })
        // }
    })

    // Fungsi Delete
    $('#OkCheck').click(() => {

        let id = $("#idCheck").val()
        window.apiClient.santriSantri.delete(id)
            .done((data) => {
                $.doneMessage('Berhasil dihapus.', 'Santri Santri')
                deleteRow(id)

            })
            .fail(($xhr) => {
                $.failMessage('Gagal dihapus.', 'Santri Santri')
            }).
            always(() => {
                $('#ModalCheck').modal('toggle')
            })
    })

    // Clik Tambah
    $('#tambah').on('click', () => {
        $('#myModalLabel').html('Tambah Menu')
        $('#id').val('')
        $('#menu_menu_id').val('')
        $('#nama').val('')
        $('#index').val('')
        $('#icon').val('')
        $('#url').val('')
        $('#keterangan').val('')
        $('#status').val('')

        $('#myModal').modal('toggle')
    })

})

// Click Hapus
const Hapus = (id) => {
    $("#idCheck").val(id)
    $("#LabelCheck").text('Form Hapus')
    $("#ContentCheck").text('Apakah anda yakin akan menghapus data ini?')
    $('#ModalCheck').modal('toggle')
}

// Click Ubah
const Ubah = (id) => {
    window.apiClient.santriSantri.detail(id)
        .done((data) => {

            $('#myModalLabel').html('Ubah Menu')
            $('#id').val(data.id)
            $('#menu_menu_id').val(data.parent)
            $('#nama').val(data.nama)
            $('#index').val(data.index)
            $('#icon').val(data.icon)
            $('#url').val(data.url)
            $('#keterangan').val(data.keterangan)
            $('#status').val(data.status)

            $('#myModal').modal('toggle')
        })
        .fail(($xhr) => {
            $.failMessage('Gagal mendapatkan data.', 'Santri Santri')
        })
}