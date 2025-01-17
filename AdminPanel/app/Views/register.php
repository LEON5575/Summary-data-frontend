<!-- <h1>Hello I am Register Page</h1> -->
<div class="container d-flex justify-content-center align-items-center pb-2rem" style="height: 100vh;">
        <div class="card" style="width: 300px;">
            <div class="card-body">
                <h1 class="card-title text-center">Register Here</h1>
                <form method="post" action="<?php echo base_url('/register')?>">
                <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">mobile</label>
                        <input name="mobile" type="number" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>