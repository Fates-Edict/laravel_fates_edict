@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <button type="button" id="btnAdd" class="btn btn-primary my-3">Create New <i class="fas fa-add"></i></button>
    <select class="form-select mb-3" id="filter_by_hospital">
        <option selected>Filter by Hospital</option>
        <?php foreach($hospitals as $hospital) : ?>
            <option value="<?= $hospital['id'] ?>">{{ $hospital['name'] }}</option>
        <?php endforeach ?>
    </select>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Actions</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>

            <div class="row">
                <div id="information" class="col-6"></div>
                <div id="pagination" class="col-6"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="form">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <label for="hospital_id">Hospital</label>
                        <select class="form-select" id="hospital_id" name="hospital_id">
                            <option selected>Select Hospital</option>
                            <?php foreach($hospitals as $hospital) : ?>
                                <option value="<?= $hospital['id'] ?>">{{ $hospital['name'] }}</option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback" id="invalidHospital"></div>
                    </div>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="name">
                        <div class="invalid-feedback" id="invalidName"></div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input name="address" type="text" class="form-control" id="address">
                        <div class="invalid-feedback" id="invalidAddress"></div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input name="phone" type="phone" class="form-control" id="phone">
                        <div class="invalid-feedback" id="invalidPhone"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    const token = localStorage.getItem('token')
    function getData(page = '?table=true&page=1', hospitalId = null) {
        let url = `/api/patients${page}`
        if(hospitalId) url += '&hospital_id=' + hospitalId
        $.ajax({
            url,
            headers: {'Authorization': `Bearer ${token}`},
            statusCode: {
                200: (res) => {
                    if(res.data.data) {
                        const data = res.data.data
                        $('#tbody').text('')
                        data.forEach((row) => {
                            let append = `
                                <tr>
                            `
                            append += `<td>
                                <button class="btn btn-sm btn-round btnEdit btn-primary" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-round btnDelete btn-danger" data-id="${row.id}"><i class="fas fa-trash"></i></button>
                            </td>`
                            append += `<td>${row.name}</td>`
                            append += `<td>${row.address}</td>`
                            append += `<td>${row.phone}</td>`
                            append += '</tr>'
                            $('#tbody').append(append)
                        })
                        $('#information').text(`Showing ${res.data.from ?? 0} to ${res.data.to ?? 0} of ${res.data.total ?? 0} results.`)
                        if(res.data.links) {
                            const links = res.data.links
                            let appendLink = `<nav><ul class="pagination">`
                            links.forEach((row) => {
                                appendLink += `<li class="page-item"><button data-url="${row.url}" class="${row.active ? 'active' : ''} page-link btnLink">${row.label}</button></li>`
                            })
                            appendLink += '</nav>'
                            $('#pagination').text('')
                            $('#pagination').append(appendLink)
                        }
                    }
                }
            }
        })
    }

    function findById(id = undefined) {
        if(id) {
            $('#form').trigger('reset')
            $('#form .form-control').removeClass('is-invalid')
            $('#id').val('')
            $('#modalFormLabel').text('Edit')

            $.ajax({
                url: `/api/patients/${id}`,
                headers: {'Authorization': `Bearer ${token}`},
                statusCode: {
                    200: (res) => {
                        if(res.data) {
                            const data = res.data
                            $('#id').val(data.id)
                            $('#hospital_id').val(data.hospital_id)
                            $('#name').val(data.name)
                            $('#address').val(data.address)
                            $('#phone').val(data.phone)
                            $('#modalForm').modal('show')
                        }
                    }
                }
            })
        }
    }

    getData()

    $('#btnAdd').click(() => {
        $('#id').val('');
        $('#form').trigger('reset');
        $('#form .form-control').removeClass('is-invalid');
        $('#modalFormLabel').text('Create New');
        $('#modalForm').modal('show');
    })

    $(document).on('click', '.btnEdit', function() {
        const id = $(this).data('id')
        if(id) findById(id)
    })

    $(document).on('click', '.btnDelete', function() {
        const id = $(this).data('id')
        if(id) {
            $.ajax({
                url: '/api/patients/' + id,
                headers: {'Authorization': `Bearer ${token}`},
                method: 'DELETE',
                statusCode: {
                    200: (res) => {
                        Swal.fire({
                            text: res.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        getData()
                    }
                }
            })
        }
    })

    $(document).on('submit', '#form', (e) => {
        e.preventDefault()
        const id = $('#id').val()
        let url = `/api/patients`
        if(id) url += `/${id}`
        const name = $('#name').val()
        const method = id ? 'PUT' : 'POST'
        $.ajax({
            url,
            method,
            headers: {'Authorization': `Bearer ${token}`},
            data: $('#form').serialize(),
            statusCode: {
                400: (res) => {
                    const response = res.responseJSON
                    const errors = response.errors

                    if(errors.name) {
                        $('#name').addClass('is-invalid') 
                        $('#invalidName').text(errors.name[0])
                    } else {
                        $('#name').removeClass('is-invalid')
                        $('#invalidName').text('')
                    }

                    if(errors.address) {
                        $('#address').addClass('is-invalid') 
                        $('#invalidAddress').text(errors.address[0])
                    } else {
                        $('#address').removeClass('is-invalid')
                        $('#invalidAddress').text('')
                    }

                    if(errors.phone) {
                        $('#phone').addClass('is-invalid') 
                        $('#invalidPhone').text(errors.phone[0])
                    } else {
                        $('#phone').removeClass('is-invalid')
                        $('#invalidPhone').text('')
                    }

                    if(errors.hospital_id) {
                        $('#hospital_id').addClass('is-invalid') 
                        $('#invalidHospital').text(errors.hospital_id[0])
                    } else {
                        $('#hospital_id').removeClass('is-invalid')
                        $('#invalidHospital').text('')
                    }
                },
                201: (res) => {
                    $('#modalForm').modal('hide')
                    Swal.fire({
                        text: res.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    getData()
                }
            }
        })
    })

    $(document).on('click', '.btnLink', function() {
        const page = $(this).data('url')
        if(page) getData(page)
    })

    $('#filter_by_hospital').on('change', () => {
        const hospital_id = $('#filter_by_hospital').val()
        if(hospital_id && hospital_id != 'Filter by Hospital') getData('?table=true&page=1', hospital_id)
        else getData()
    })

</script>
@endpush