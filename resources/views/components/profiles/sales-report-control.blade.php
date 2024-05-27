<div class="title-container">
    <h1>View Sales Report</h1>
</div>
<div class="control-container" id="report">
    <div class="view-selector" id="report-view-selector">
        <!--TODO: Add Action and Method to this form-->
        <form method="" action="">
            <select name="product" class="dropdown-box" title="product">
                <option value="product1">Product 1</option>
                <option value="product2">Product 2</option>
                <option value="product3">Product 3</option>
                <option value="product4">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    Repellendus quod blanditiis recusandae autem qui facilis nemo illum numquam et.
                    Perferendis modi id officiis veniam laboriosam explicabo rem neque ad delectus!
                </option>
            </select>
            <div class="form-date-container">
                <label for="form-date">Form Date : </label>
                <input type="date" id="form-date" name="Start Date">
            </div>
            <div class="end-date-container">
                <label for="to-date">To Date : </label>
                <input type="date" id="to-date" name="End Date">
            </div>
            <button type="submit" class="view-button">VIEW</button>
        </form>
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
            <tr>
                <td>Earphone</td>
                <td>120</td>
                <td>RM 130.00</td>
                <td>RM 15600</td>
            </tr>
        </tbody>
    </table>
    <div id="graph-section">
        <h2>SALES EACH MONTH</h2>
        <div class="view-selector" id="graph-view-selector">
            <!--TODO: Add Action and Method to this form-->
            <form method="get" action="">
                <select name="product" class="dropdown-box" title="product">
                    <option value="product1">Product 1</option>
                    <option value="product2">Product 2</option>
                    <option value="product3">Product 3</option>
                    <option value="product4">Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        Repellendus quod blanditiis recusandae autem qui facilis nemo illum numquam et.
                        Perferendis modi id officiis veniam laboriosam explicabo rem neque ad delectus!
                    </option>
                </select>
                <div class="year-selector">
                    <label for="year">Year : </label>
                    <select name="year" id="year" class="dropdown-box">
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </select>
                </div>
                <button type="submit" class="view-button">VIEW</button>
            </form>
        </div>
        <div>
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>