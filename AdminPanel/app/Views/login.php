<div class="container d-flex justify-content-center align-items-center pb-2rem" style="height: 100vh;">
        <div class="card" style="width: 300px;">
            <div class="card-body">
                <h1 class="card-title text-center">Login Page</h1>
                <form method="post" action="<?php echo base_url('/login')?>">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>

   
