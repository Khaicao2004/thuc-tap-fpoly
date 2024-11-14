$(document).ready(function () {
    $.ajax({
        url: "api/dashboard/suppliers",
        method: "GET",
        success: function(data){
           var supplierProducts = $("#dashboard-suppliers");
           supplierProducts.empty();
           data.forEach(supplier => {
            supplierProducts.append(
                `<p class="mb-2">${ supplier.supplier_name }<span class="float-end">${supplier.percentage.toFixed(2)} %</span></p>
                <div class="progress mt-2 mb-2" style="height: 6px;">
                    <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: ${supplier.percentage}%" aria-valuenow="${supplier.percentage}" aria-valuemin="0" aria-valuemax="${supplier.percentage}"></div>
                </div> 
                `
               );
           });        
            
        }
    });
})

