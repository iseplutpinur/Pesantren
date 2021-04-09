$(() => {
    // initialize responsive datatable
    $.initBasicTable('#dt_basic')
    const $table = $('#dt_basic').DataTable();
    $table.columns(0)
        .order('asc')
        .draw()

    // Add Row
    const addRow = (data) => {
        let row = [
            data.nama,
            `
            <div>
            <button class="btn btn-primary btn-sm"  id="btn-ubah-${data.id}" data-toggle="modal" data-target="#modalUbah" data-id="${data.id}" data-nama="${data.nama}" onclick="Ubah(this)">
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
        btn.data('nama', data.nama);
    }

    // Delete Row
    const deleteRow = (id) => {
        $table.row('[data-id=' + id + ']').remove().draw()
    }

    // Fungsi simpan tambah
    $('#form-tambah').submit((ev) => {
        ev.preventDefault();

        let nama = $("#nama").val();

        window.apiClient.santriKelas.insert(nama)
            .done((data) => {
                $.doneMessage('Berhasil ditambahkan.', 'Santri Kelas')
                addRow(data)

            })
            .fail(($xhr) => {
                $.failMessage('Gagal ditambahkan.', 'Santri Kelas')
            }).
            always(() => {
                $('#modalTambah').modal('toggle')
            })
    })


    // Fungsi Update
    $('#form-ubah').submit((ev) => {
        ev.preventDefault();

        let nama = $("#nama-ubah").val();
        let id = $("#id-ubah").val();

        window.apiClient.santriKelas.update(id, nama)
            .done((data) => {
                $.doneMessage('Berhasil diubah.', 'Santri Santri')
                editRow(id, data)

            })
            .fail(($xhr) => {
                $.failMessage('Gagal diubah.', 'Santri Santri')
            }).
            always(() => {
                $('#modalUbah').modal('toggle')
            })
    })

    // Fungsi Delete
    $('#OkCheck').click(() => {

        let id = $("#idCheck").val()
        window.apiClient.santriKelas.delete(id)
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
    $("#LabelCheck").text('Hapus Kelas Santri')
    $("#ContentCheck").text('Apakah anda yakin akan menghapus data ini?')
    $('#ModalCheck').modal('toggle')
}

// Click Ubah
const Ubah = (id) => {
    let data = $(id);
    $("#id-ubah").val(data.data('id'));
    $("#nama-ubah").val(data.data('nama'));
}