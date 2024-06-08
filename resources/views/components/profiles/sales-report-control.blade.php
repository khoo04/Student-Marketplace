@props(['products','years'])
<div class="title-container">
    <h1>View Sales Report</h1>
</div>
<div class="control-container" id="report">
    <div class="view-selector" id="report-view-selector">
        <!--TODO: Add Action and Method to this form-->
        <div class="filter-container">
            <select name="product" class="dropdown-box" id="product_sales_dropdown" title="product">
                @if (empty($products))
                    <option>NO PRODUCT FOUND</option>
                @else
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                @endif
            </select>
            <div class="form-date-container">
                <label for="form-date">From Date : </label>
                <input type="date" id="sales-from-date" name="Start Date">
            </div>
            <div class="end-date-container">
                <label for="to-date">To Date : </label>
                <input type="date" id="sales-to-date" name="End Date">
            </div>
            <button type="button" class="view-button" id="product_sales_view_button">VIEW</button>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity Sold</th>
                <th>Unit Price</th>
                <th>Total Sales</th>
            </tr>
        </thead>
        <tbody>

            <tr id="data-row">
                <td colspan="4">
                    @if (empty($products))
                        No Product Found
                    @else
                        Select a product and date range to view report
                    @endif
                </td>
            </tr>

            {{-- Prompt User to Select --}}
            {{--
                <tr>
                    <td>{{$products[0]->name}}</td>
                    <td>120</td>
                    <td>RM 130.00</td>
                    <td>RM 15600</td>
                </tr>
                --}}


        </tbody>
    </table>
    <div id="graph-section">
        <h2>SALES EACH MONTH</h2>
        <div class="view-selector" id="graph-view-selector">
            <!--TODO: Add Action and Method to this form-->
            <div class="filter-container">
                <select id="product-dropdown" class="dropdown-box" title="product">
                    @if (empty($products))
                        <option>NO PRODUCT FOUND</option>
                    @else
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    @endif
                </select>
                <div class="year-selector">
                    <label for="year">Year : </label>
                    <select name="year" id="year-dropdown" class="dropdown-box">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="view-button" id="view-graph-button">VIEW</button>
                </form>
            </div>
            <div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const ctx = document.getElementById('myChart');
        var chart;
        $("#view-graph-button").click(function(){
            productID = $('#product-dropdown').val();
            year = $("#year-dropdown").val();
            requestGraph(productID,year);
        });

        $("#product_sales_view_button").click(function(){
            productID = $("#product_sales_dropdown").val();
            fromDate = $("#sales-from-date").val();
            toDate = $("#sales-to-date").val();

            requestData = {
                productID: productID,
                fromDate: fromDate,
                toDate: toDate,
            };

            console.log(requestData);
            requestTableData(requestData);
        });


        requestGraph($('#product-dropdown').val(),$("#year-dropdown").val());

        function renderGraph(dataset) {
            if (chart != undefined){
                chart.destroy();
            }
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mac', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                        'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        label: 'Sales',
                        data: dataset,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function requestGraph(productID, year) {
            $.ajax({
                type: "GET",
                url: "{{route('ajax.reportData')}}",
                data: {
                    productID: productID,
                    year: year,
                },
                success: function(response) {
                    renderGraph(response.data);
                }
            });
        }

        function requestTableData(requestData){
            $.ajax({
                type: "GET",
                url: "{{route('ajax.salesTableData')}}",
                data: requestData,
                success: function (response) {
                    $("#data-row").html(response.html);
                }
            });
        }


    });
</script>
