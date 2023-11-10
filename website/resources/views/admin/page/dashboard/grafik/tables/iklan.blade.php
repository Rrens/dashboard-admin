<tr>
    <td class="text-bold-500">
        ${value.name}
    </td>
    <td class="text-bold-500">
        ${value.merchant_id}
    </td>
    <td class="text-bold-500">
        ${value.category_id}
    </td>
    <td class="text-bold-500">
        ${value.merchant[0].province}
    </td>
    <td class="text-bold-500">
        ${value.merchant[0].city}
    </td>
    <td class="text-bold-500">
        ${value.description}
    </td>
    <td class="text-bold-500">
        ${value.notes}
    </td>
    <td class="text-bold-500">
        ${value.price}
    </td>
    <td class="text-bold-500">
        ${value.picture}
    </td>
    <td class="text-bold-500">
        ${value.count_order}
    </td>
    <td class="text-bold-500">
        ${value.rating}
    </td>
    <td class="text-bold-500">
        ${value.count_view}
    </td>
    <td>
        <button class="btn btn-light-warning btn-sm" onclick="favoriteAdsEdit(${value.id})" data-bs-toggle="modal"
            data-bs-target="#modalEdit">
            <i class="bi bi-pencil-fill"></i>
        </button>
        {{-- <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal" onclick="favoriteAdsdelete(${value.id})"
            data-bs-target="#modalDelete">
            <i class="bi bi-trash-fill"></i>
        </button> --}}
    </td>
</tr>
