<script>
    // Merchant Verifikasi dan tidak
    // $.ajax({
    //     url: "{{ env('API_URL') . 'dashboard/merchant/data-verify' }}",
    //     method: 'GET',
    //     success: function(data) {
    //         // console.log(data.data)
    //         const data_api = data.data;
    //         let newRow = null;
    //         $('#table_data_verify tbody').empty();
    //         data_api.forEach(value => {
    //             newRow += `
    //                 <tr>

    //                     <td class="text-bold-500">
    //                         ${value.name}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.id}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.email}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.phone_number}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.address}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.city}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.province}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.profile_picture}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.id_card_number}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.npwp}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.last_login}
    //                     </td>
    //                     <td>
    //                         <button class="btn btn-light-warning btn-sm" onclick="detail(this)"
    //                             data-bs-toggle="modal" data-bs-target="#modalDetail">
    //                             <i class="bi bi-pencil-fill"></i>
    //                         </button>
    //                         <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
    //                             onclick="delete(this)" data-bs-target="#modalDelete">
    //                             <i class="bi bi-trash-fill"></i>
    //                         </button>
    //                     </td>
    //                 </tr>
    //             `;
    //         });

    //         $('#table_data_verify tbody').append(newRow);
    //     }
    // })

    // // Pengguna Aktif dan tidak
    // $.ajax({
    //     url: "{{ env('API_URL') . 'dashboard/merchant/data-merchant-active' }}",
    //     method: 'GET',
    //     success: function(data) {
    //         const data_api = data.data;
    //         let newRow = null;

    //         $('#table_data_active_and_not tbody').empty();

    //         data_api.forEach(value => {
    //             newRow += `
    //                 <tr>

    //                     <td class="text-bold-500">
    //                         ${value.id}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.name}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.email}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.phone_number}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.address}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.city}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.province}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.profile_picture}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.id_card_number}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.npwp}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.last_login}
    //                     </td>
    //                     <td>
    //                         <button class="btn btn-light-warning btn-sm" onclick="detail(this)"
    //                             data-bs-toggle="modal" data-bs-target="#modalDetail">
    //                             <i class="bi bi-pencil-fill"></i>
    //                         </button>
    //                         <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
    //                             onclick="delete(this)" data-bs-target="#modalDelete">
    //                             <i class="bi bi-trash-fill"></i>
    //                         </button>
    //                     </td>
    //                 </tr>
    //             `;
    //         });

    //         $('#table_data_active_and_not tbody').append(newRow);
    //     }
    // })
</script>
