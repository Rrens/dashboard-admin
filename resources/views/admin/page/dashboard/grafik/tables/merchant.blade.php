<tr>
    <td class="text-bold-500">
        ${value.id}
    </td>
    <td class="text-bold-500">
        ${value.name}
    </td>
    <td class="text-bold-500">
        ${value.email}
    </td>
    <td class="text-bold-500">
        ${value.phone_number}
    </td>
    <td class="text-bold-500">
        ${value.address}
    </td>
    <td class="text-bold-500">
        ${value.city}
    </td>
    <td class="text-bold-500">
        ${value.province}
    </td>
    <td class="text-bold-500">
        ${value.profile_picture}
    </td>
    <td class="text-bold-500">
        ${value.id_card_number}
    </td>
    <td class="text-bold-500">
        ${value.npwp}
    </td>
    <td class="text-bold-500">
        ${value.last_login}
    </td>
    <td>
        <button class="btn btn-light-warning btn-sm" onclick="VerifyEdit(${value.id})" data-bs-toggle="modal"
            data-bs-target="#modalEdit">
            <i class="bi bi-pencil-fill"></i>
        </button>
        <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal" onclick="VerifyDestroy(${value.id})"
            data-bs-target="#modalDelete">
            <i class="bi bi-trash-fill"></i>
        </button>
    </td>
</tr>
