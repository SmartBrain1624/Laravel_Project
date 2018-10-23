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