@extends('layouts.backend.master')

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-th-list"></i> {{ $title }}</h1>
            <p>Display {{ $title }} Data Effectively</p>
        </div>

        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">{{ $title }}</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">{{ $title }} Form</h3>
                <div class="tile-body">
                    <form action="{{ route('pathao.send', base64_encode($order->id)) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="form-group col-md-7">
                                        <label class="control-label">Recipient Name</label>
                                        <input class="form-control" value="{{ $order->name }}" readonly>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label class="control-label">Recipient Phone</label>
                                        <input class="form-control" value="{{ $order->phone }}" readonly>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="control-label">Recipient Address</label>
                                        <textarea class="form-control" readonly>{{ $order->address }}</textarea>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">City <span class="font-weight-bold text-danger">*</span></label>
                                        <select name="recipient_city" id="city" class="form-control form-control-line" required>
                                            <option value="">Select City</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city['city_id'] }}">
                                                    {{ $city['city_name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">Zone <span class="font-weight-bold text-danger">*</span></label>
                                        <select name="recipient_zone" id="zone" class="form-control form-control-line" required></select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">Area <span class="font-weight-bold text-danger">*</span></label>
                                        <select name="recipient_area" id="area" class="form-control form-control-line" required></select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label class="form-label">Item Weight <span class="font-weight-bold text-danger">*</span></label>
                                        <select name="item_weight" id="item_weight" class="form-control form-control-line" required>
                                            <option value="">Select Item Weight</option>
                                            <option value="0.5">0.5 kg</option>
                                            <option value="1">1 kg</option>
                                            <option value="2">2 kg</option>
                                            <option value="3">3 kg</option>
                                            <option value="4">4 kg</option>
                                            <option value="5">5 kg</option>
                                            <option value="6">6 kg</option>
                                            <option value="7">7 kg</option>
                                            <option value="8">8 kg</option>
                                            <option value="9">9 kg</option>
                                            <option value="10">10 kg</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-10"></div>
                            <div class="form-group col-md-2 align-self-end">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Send Pathao</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('library-css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('custom-css')
@endpush

@push('library-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endpush

@push('custom-js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        document.getElementById('city').addEventListener('change', function () {
            let cityId = this.value;
            fetch(`/secure/pathao/zones/${cityId}`)
                .then(res => res.json())
                .then(data => {
                    let zoneSelect = document.getElementById('zone');
                    zoneSelect.innerHTML = '<option value="">Select Zone</option>';
                    data.data.data.forEach(zone => {
                        zoneSelect.innerHTML += `<option value="${zone.zone_id}">${zone.zone_name}</option>`;
                    });
                });
        });

        document.getElementById('zone').addEventListener('change', function () {
            let zoneId = this.value;
            fetch(`/secure/pathao/areas/${zoneId}`)
                .then(res => res.json())
                .then(data => {
                    let areaSelect = document.getElementById('area');
                    areaSelect.innerHTML = '<option value="">Select Area</option>';
                    data.data.data.forEach(area => {
                        areaSelect.innerHTML += `<option value="${area.area_id}">${area.area_name}</option>`;
                    });
                });
        });
    </script>
@endpush
