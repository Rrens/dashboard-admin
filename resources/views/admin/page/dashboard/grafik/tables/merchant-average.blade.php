<tr>
    <td class="text-bold-500">
        ${value.id}
    </td>
    <td class="text-bold-500">
        ${value.merchant_id}
    </td>
    <td class="text-bold-500">
        ${value.ads_id}
    </td>
    <td class="text-bold-500">
        ${value.total_transaction}
    </td>
    <td class="text-bold-500">
        ${monthNames[value.month]}
    </td>
    <td>
        <button class="btn btn-light-warning btn-sm" onclick="averageEdit(${value.merchant_id})" data-bs-toggle="modal"
            data-bs-target="#modalEdit">
            <i class="bi bi-pencil-fill"></i>
        </button>
        {{-- <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
            onclick="averageDestroy(${value.merchant_id})" data-bs-target="#modalDelete">
            <i class="bi bi-trash-fill"></i>
        </button> --}}
    </td>
</tr>
