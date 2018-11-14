<div class="row">
    <div class="col-md-6 margin-bottom-30">
        <div class="hs_heading medium">
            <h3>Forms (Basic example)</h3>
        </div>
        <div class="hs_input">
            <label>Email address</label>
            <input type="email" class="form-control" placeholder="Email">
        </div>
        <div class="hs_input">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Password">
        </div>
        <div class="hs_input">
            <label>Dropdown</label>
            <select class="form-control">
                <option value="">1</option>
                <option value="">2</option>
                <option value="">3</option>
            </select>
        </div>
        <div class="hs_input">
            <label>Textarea</label>
            <textarea rows="4" class="form-control" placeholder="Your message"></textarea>
        </div>
        <div class="hs_input">
            <label for="exampleInputFile">File input</label>
            <input type="file" id="exampleInputFile" class="form-control">
            <p class="help-block">Example block-level help text here.</p>
        </div>
        <div class="hs_checkbox">
            <input type="checkbox" id="check_me_out" checked="">
            <label for="check_me_out">Check me out</label>
        </div>

        <div class="hs_radio_list">
            <div class="hs_radio">
                <input type="radio" id="radio1" name="radio_list" checked>
                <label for="radio1">radio1</label>
            </div>
            <div class="hs_radio">
                <input type="radio" id="radio2" name="radio_list">
                <label for="radio2">radio2</label>
            </div>
        </div>

        <button type="submit" class="btn">Submit</button>
    </div>

    <div class="col-md-6">
        <div class="hs_heading medium">
            <h3>Tabs</h3>
        </div>

        <div class="hs_tabs">
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#home">Home</a></li>
                <li><a data-toggle="pill" href="#menu1">Menu 1</a></li>
                <li><a data-toggle="pill" href="#menu2">Menu 2</a></li>
            </ul>
              
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <h3>HOME</h3>
                    <p>Some content.</p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Some content in menu 1.</p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Some content in menu 2.</p>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-12">
        <div class="hs_heading medium">
            <h3>Datatable</h3>
        </div>
        <div class="hs_datatable_wrapper">
            <table class="hs_datatable table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Parker</td>
                        <td>johnparker@gmail.com</td>
                        <td>
                            <a href="" class="btn"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>