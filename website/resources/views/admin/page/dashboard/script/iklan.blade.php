<script>
    // Iklan Verifikasi dan tidak
    // $.ajax({
    //     url: "{{ env('API_URL') . 'dashboard/iklan/data-verify' }}",
    //     method: 'GET',
    //     success: function(data) {
    //         // console.log(data.data)
    //         let data_api = null
    //         if (label == 'active') {
    //             data_api = data.data;
    //         } else {
    //             data_api = data.data_not_active;
    //         }
    //         let newRow = null;
    //         $('#table_data_verify tbody').empty();
    //         data_api.forEach(value => {
    //             newRow += `
    //                 <tr>

    //                     <td class="text-bold-500">
    //                         ${value.name}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.merchant_id}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.category_id}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.merchant[0].province}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.merchant[0].city}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.description}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.notes}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.price}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.picture}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.count_order}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.rating}
    //                     </td>
    //                     <td class="text-bold-500">
    //                         ${value.count_view}
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
</script>
