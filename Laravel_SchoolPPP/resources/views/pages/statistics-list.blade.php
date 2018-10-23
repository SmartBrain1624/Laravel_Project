@extends('common.page_wrapper.index')

@section('filters')
    <div class="row" style="margin-top: 15px;">
        <div class="col-lg-6 m-form__group-sub">
            <select class="form-control m-input" id="year">
                <option value="">
                    Please select year
                </option>
                @foreach($years as $year)
                    <option value="{{ $year }}" @if(date('Y') == $year)selected="selected"@endif>{{ $year }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-6 m-form__group-sub">
            <select class="form-control m-input" id="month">
                <option value="">
                    Please select month
                </option>
                @foreach($months as $id => $month)
                    <option value="{{ $id }}">{{ $month }}</option>
                @endforeach
            </select>
        </div>
    </div>
@endsection

@section('content')
    <input type="hidden" id="school_id" value="{{ $school->id }}" />
    <div class="m-portlet m-portlet--mobile" >
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ $school->name }}'s Statistics data
                    </h3>
                </div>
            </div>


        </div>
        <div class="m-portlet__body">
            <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded" id="local_data" style="overflow-x: auto;">
                <table class="m-datatable__table" style="display: block; min-height: 300px; overflow-x: auto;">
                    <thead class="m-datatable__head">
                        <tr  class="m-datatable__row">
                            <th data-field="Year" class="m-datatable__cell"><span style="width: 40px;">Year</span></th>
                            <th data-field="Week" class="m-datatable__cell"><span style="width: 40px;">Week</span></th>
                            <th data-field="Month" class="m-datatable__cell"><span style="width: 70px;">Month</span></th>
                            <th data-field="Euro" class="m-datatable__cell"><span style="width: 110px;">Electricity, &euro;</span></th>
                            <th data-field="kWH" class="m-datatable__cell"><span style="width: 110px;">Electricity, kWh</span></th>
                            <th data-field="Heating Euro" class="m-datatable__cell"><span style="width: 110px;">Heating, &euro;</span></th>
                            <th data-field="Heating kWH" class="m-datatable__cell"><span style="width: 110px;">Heating, kWh</span></th>
                            <th data-field="Water Euro" class="m-datatable__cell"><span style="width: 100px;">Water, &euro;</span></th>
                            <th data-field="Water Litres" class="m-datatable__cell"><span style="width: 110px;">Water,litres</span></th>
                            <th data-field="Actions" class="m-datatable__cell"><span style="width: 180px;">Actions</span></th>
                        </tr>
                    </thead>

                    <tbody class="m-datatable__body" id="table_body" style="">
                    @foreach ($data as $value)
                        <tr class="m-datatable__row">
                            <td class="m-datatable__cell"><span style="width: 40px;">{{$value['year']}}</span></td>
                            <td class="m-datatable__cell"><span style="width: 40px;">{{$value['week']}}</span></td>
                            <td class="m-datatable__cell"><span style="width: 70px;">{{$value['month']}}</span></td>
                            <td class="m-datatable__cell"><span style="width: 110px;">{{$value['elect_eur']}}</span></td>
                            <td class="m-datatable__cell"><span style="width: 110px;">{{$value['elect_kwh']}}</span></td>
                            <td class="m-datatable__cell"><span style="width: 110px;">{{$value['heating_eur']}}</span></td>
                            <td class="m-datatable__cell"><span style="width: 110px;">{{$value['heating_kwh']}}</span></td>
                            <td class="m-datatable__cell"><span style="width: 100px;">{{$value['water_eur']}}</span></td>
                            <td class="m-datatable__cell"><span style="width: 110px;">{{$value['water_litres']}}</span></td>
                            <td class="m-datatable__cell">
                                <span style="width: 150px;" class="btn-group">
                                    <a href="/school/statistic/{{$value['id']}}/edit"><button type="button" id="edit-statistic" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></a>

                                    <button type="button" data-deleteid="{{$value['id']}}" class="btn btn-danger btn-sm delete-school" id="m_sweetalert_demo_7">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                    </button>
                                    
                                    {{-- <a href="/school/statistic/{{$value->id}}/delete"><button type="button" id="delete-statistic" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></a> --}}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection


@section('script_content')
    <script>
    var buttons = document.querySelectorAll('.delete-school')
    buttons.forEach(button => button.addEventListener('click', event => {
        var {deleteid} = event.target.dataset
        swal({
            title: 'Would you like to delete item?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
                swal(
                'Deleted!',
                'success'
                )
                window.location =  `/school/statistic/${deleteid}/delete`
            }
            })
    })
    )
    
    </script>

    
<script>
    const getValue = selector => document.querySelector(selector).value
    const getSelector = (selector) => document.querySelector(selector)


    const school_id = getValue('#school_id')

    function getData() {
        const [year, month] = [getValue('#year'), getValue('#month')]
        $.get( `/school/${school_id}/data?year=${year}&month=${month}`, ( response ) => {
            const tableBody = getSelector('#table_body')
                tableBody.innerHTML = response
            });
    }


    document.addEventListener('DOMContentLoaded', () => {
        const selectBoxes = [getSelector('#year'), getSelector('#month')]
        selectBoxes.forEach( box => box.addEventListener( 'change', event => {
            getData()
        } ) )

        })
</script>
@endsection


