$(document).ready(function () {
    // hàm lấy dữ liệu từ API
    function fetchStatistics(type = "day") {
        $.ajax({
            url: "api/statistics",
            type: "GET",
            data: { type: type },
            success: function (response) {
                $("#totalRevenue").text(formatCurrency(response.totalRevenue));
                $("#totalOrders").text(response.totalOrders);
                $("#totalCanceledOrders").text(response.totalCanceledOrders);
                $("#deliverySuccessRatio").text(response.deliverySuccessRatio);
                $("#totalMembersAllTime").text(response.totalMembersAllTime);
                $("#totalCanceledOrdersAllTime").text(
                    response.totalCanceledOrdersAllTime
                );
                $("#totalRevenueAllTime").text(
                    formatCurrency(response.totalRevenueAllTime)
                );
                $("#totalOrdersAllTime").text(response.totalOrdersAllTime);
                updateChart(response);
            },
            error: function (xhr) {
                console.error("Error status: " + xhr.status);
                console.error("Response text: " + xhr.responseText);
            },
        });
    }
    // Hàm định dạng tiền tệ VNĐ
    function formatCurrency(value) {
        // Chuyển số thành chuỗi và thêm dấu phân cách hàng nghìn
        let parts = value.toFixed(2).split(".");
        // Thêm dấu phân cách hàng nghìn
        let integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // Kết hợp lại thành chuỗi tiền tệ
        return `${integerPart}`;
    }

    function updateChart(data) {
        var options = {
            series: [
                {
                    name: "Doanh thu",
                    data: [data.totalRevenueAllTime, data.totalRevenue],
                },
                {
                    name: "Đơn hàng",
                    data: [data.totalOrdersAllTime, data.totalOrders],
                },
                {
                    name: "Đơn hàng bị hủy",
                    data: [
                        data.totalCanceledOrdersAllTime,
                        data.totalCanceledOrders,
                    ],
                },
            ],
            chart: {
                type: "bar",
                height: 400,
            },
            colors: ["#FF4560", "#00E396", "#00BFFF"],
            xaxis: {
                categories: ["Tổng", "Hiện tại"],
            },
            title: {
                text: "Thống kê",
                align: "left",
            },
        };

        var chart = new ApexCharts(
            document.querySelector("#customer_impression_charts"),
            options
        );
        chart.render();
    }
    //bestSelling
    function fetchBestSellingProduct(type = "today") {
        $.ajax({
            url: "api/best-salling-product",
            type: "GET",
            data: { type: type },
            dataType: "json", // chỉ định phản hồi là json
            success: function (data) {
                var productList = $("#bestSellingProduct");
                var stt = 0;
                productList.empty(); //xóa dữ liệu cũ
                data.forEach(function (product) {
                    productList.append(
                        `
                        <tr>
                            <td>${(stt += 1)}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="avatar-sm bg-light rounded p-1 me-2">
                                        <img src="storage/${
                                            product.product_img_thumbnail
                                        }" alt="${product.product_name}"
                                            class="img-fluid d-block" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h5 class="fs-14 my-1"><a
                                    href="apps-ecommerce-product-details.html"
                                    class="text-reset">${product.product_name}</a></h5>
                                </div>
                            </td>
                            <td>
                                <h5 class="fs-14 my-1 fw-normal">${
                                    product.product_price_sale
                                } VNĐ</h5>
                            </td>
                            <td>
                                <h5 class="fs-14 my-1 fw-normal">${
                                    product.total_orders
                                }</h5>
                            </td>
                                <td>
                                    <h5 class="fs-14 my-1 fw-normal">${
                                        product.total_amount
                                    } VNĐ</h5>
                                </td>
                            </tr>
                        `
                    );
                });
            },
            error: function (xhr) {
                console.error("Error status: " + xhr.status);
                console.error("Response text: " + xhr.responseText);
            },
        });
    }
    function fetchRecentOrders() {
        $.ajax({
            url: "api/recent-orders",
            method: "GET",
            success: function (data) {
                console.log(data);
                var orderList = $("#recentOrders");
                var stt = 0;
                orderList.empty();
                data.forEach(function (order) {
                    var itemProducts = order.order_items.map(function(item){
                        return `<div>${item.product_name} - ${item.quatity}</div>`;
                    }).join('');
                    orderList.append(`
                        <tr>
                        <td>${stt+=1}</td>
                          <td>
                              <a href="apps-ecommerce-order-details.html"
                                  class="fw-medium link-primary">${order.id}</a>
                          </td>
                         <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">${order.user_name}</div>
                            </div>
                          </td>
                          <td>${itemProducts}</td>
                          <td>
                              <span class="text-success">${order.total_price} VNĐ</span>
                          </td>
                          <td>
                              <span class="badge bg-success-subtle text-success">${order.status_payment}</span>
                          </td>
                        </tr>
                        `);
                });
            },
            error: function(xhr) {
                console.error("Error: " + xhr.responseText);
            }
        });
    }
    //gọi hàm khi trang load
    fetchStatistics();
    fetchBestSellingProduct();
    fetchRecentOrders();
    //xử lý khi chọn khoảng thời gian
    $(".btn-timeFrame").on("click", function () {
        var type = $(this).data("type");
        // Xóa lớp selected khỏi tất cả các button
        $(".btn-timeFrame").removeClass("selected");

        // Thêm lớp selected vào button được nhấp
        $(this).addClass("selected");
        fetchStatistics(type);
    });

    $(".dropdown-item").on("click", function () {
        // Loại bỏ lớp 'selected' khỏi tất cả các nút
        $(".dropdown-item").removeClass("selected");

        // Thêm lớp 'selected' vào nút vừa được chọn
        $(this).addClass("selected");

        // Cập nhật tiêu đề dropdown
        $("#dropdownTitle").text($(this).text() + " ");
        var type = $(this).data("type");
        fetchBestSellingProduct(type);
    });
});
