@props(['products', 'years'])
<div class="title-container">
    <h1>View Sales Report</h1>
</div>
<div class="control-container" id="report">
    <div class="section-container">
        <h2 class="title">View Product Sales In Date Range</h2>
        <div class="view-selector" id="report-view-selector"> 
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

            </tbody>
        </table>
    </div>
    <div class="section-container">
        <h2 class="title">PRODUCT SALES EACH MONTH</h2>
        <div class="view-selector" id="graph-view-selector">
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
                <canvas id="proSalesChart"></canvas>
            </div>
        </div>
    </div>
    <div class="section-container">
        <h2 class="title">ALL PRODUCTS SALES PER MONTH</h2>
        <div class="view-selector" id="ps-graph-view-selector">
            <div class="filter-container">
                <div class="month-selector">
                    <label for="ps-month-dropdown">Month : </label>
                    <select name="month" id="ps-month-dropdown" class="dropdown-box" title="month">
                        <option value="1" {{ date('n') == 1 ? 'selected' : '' }}>January</option>
                        <option value="2" {{ date('n') == 2 ? 'selected' : '' }}>February</option>
                        <option value="3" {{ date('n') == 3 ? 'selected' : '' }}>March</option>
                        <option value="4" {{ date('n') == 4 ? 'selected' : '' }}>April</option>
                        <option value="5" {{ date('n') == 5 ? 'selected' : '' }}>May</option>
                        <option value="6" {{ date('n') == 6 ? 'selected' : '' }}>June</option>
                        <option value="7" {{ date('n') == 7 ? 'selected' : '' }}>July</option>
                        <option value="8" {{ date('n') == 8 ? 'selected' : '' }}>August</option>
                        <option value="9" {{ date('n') == 9 ? 'selected' : '' }}>September</option>
                        <option value="10" {{ date('n') == 10 ? 'selected' : '' }}>October</option>
                        <option value="11" {{ date('n') == 11 ? 'selected' : '' }}>November</option>
                        <option value="12" {{ date('n') == 12 ? 'selected' : '' }}>December</option>
                    </select>
                </div>

                <div class="year-selector">
                    <label for="ps-year-dropdown">Year : </label>
                    <select name="year" id="ps-year-dropdown" class="dropdown-box" title="year">
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="view-button" id="view-ps-graph-button">VIEW</button>
                </form>
            </div>
            <div>
                <canvas id="allProSalesMonthChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const proSalesCTX = document.getElementById('proSalesChart');
        const allProSalesMonthCTX = document.getElementById('allProSalesMonthChart');

        var proSalesChart;
        var allProSalesMonthChart;

        $("#product_sales_view_button").click(function() {
            productID = $("#product_sales_dropdown").val();
            fromDate = $("#sales-from-date").val();
            toDate = $("#sales-to-date").val();

            requestData = {
                productID: productID,
                fromDate: fromDate,
                toDate: toDate,
            };

            requestTableData(requestData);
        });

        function requestTableData(requestData) {
            $.ajax({
                type: "GET",
                url: "{{ route('ajax.salesTableData') }}",
                data: requestData,
                success: function(response) {
                    $("#data-row").html(response.html);
                }
            });
        }

        //Render the first product graph
        requestProSalesGraph($('#product-dropdown').val(), $("#year-dropdown").val());

        $("#view-graph-button").click(function() {
            productID = $('#product-dropdown').val();
            year = $("#year-dropdown").val();
            requestProSalesGraph(productID, year);
        });


        function renderProSalesGraph(dataset) {
            if (proSalesChart != undefined) {
                proSalesChart.destroy();
            }
            proSalesChart = new Chart(proSalesCTX, {
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

        function requestProSalesGraph(productID, year) {
            $.ajax({
                type: "GET",
                url: "{{ route('ajax.reportData') }}",
                data: {
                    productID: productID,
                    year: year,
                },
                success: function(response) {
                    renderProSalesGraph(response.data);
                }
            });
        }

        // Base color in HSL
        let baseHue = 0;
        const saturation = 70;
        const lightness = 50;

        // Object to store product-color mappings
        let productColorMap = {};

        // Function to convert HSL to Hex
        function hslToHex(h, s, l) {
            l /= 100;
            const a = s * Math.min(l, 1 - l) / 100;
            const f = n => {
                const k = (n + h / 30) % 12;
                const color = l - a * Math.max(Math.min(k - 3, 9 - k, 1), -1);
                return Math.round(255 * color).toString(16).padStart(2,
                    '0'); // convert to Hex and prefix "0" if needed
            };
            return `#${f(0)}${f(8)}${f(4)}`;
        }

        // Function to get or assign color for a product
        function getProductColor(productName) {
            if (!productColorMap[productName]) {
                // Increment hue for each new product
                const color = hslToHex(baseHue, saturation, lightness);
                productColorMap[productName] = color;
                baseHue = (baseHue + 36) % 360; // Change the hue for the next product
            }
            return productColorMap[productName];
        }

        //Request the graph when load
        requestAllProSalesMonthGraph($('#ps-month-dropdown').val(), $("#ps-year-dropdown").val());

        $("#view-ps-graph-button").click(function() {
            month = $('#ps-month-dropdown').val();
            year = $("#ps-year-dropdown").val();
            requestAllProSalesMonthGraph(month, year);
        });

        function requestAllProSalesMonthGraph(month, year) {
            $.ajax({
                type: "GET",
                url: "{{ route('ajax.allProductSalesData') }}",
                data: {
                    month: month,
                    year: year,
                },
                success: function(response) {
                    //Product Name with only 20 character
                    let labels = response.map(item => item.product_name.substring(0, 20));
                    let dataset = response.map(item => item.sales_quantity);
                    let backgroundColors = labels.map(name => getProductColor(name));

                    renderAllProSalesMonthGraph(labels, dataset, backgroundColors, month, year);
                }
            });
        }

        function renderAllProSalesMonthGraph(labels, dataset, backgroundColors, month, year) {
            if (allProSalesMonthChart != undefined) {
                allProSalesMonthChart.destroy();
            }
            allProSalesMonthChart = new Chart(allProSalesMonthCTX, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: `Sales of ${month}/${year}`,
                        data: dataset,
                        borderWidth: 2,
                        backgroundColor: backgroundColors,
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


        $("#sales-from-date, #sales-to-date").on("change", function() {
            let fromDate = $("#sales-from-date").val();
            let toDate = $("#sales-to-date").val();
            if (fromDate && toDate && new Date(fromDate) > new Date(toDate)) {
                alert("To date must be larger than from date");
                $(this).val(''); // Clear the incorrect date input
            }
        });

        //Render PRODUCTS SALES PER MONTH Graph

    });
</script>
