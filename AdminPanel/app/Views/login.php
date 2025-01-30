<div class="container d-flex justify-content-center align-items-center pb-2rem" style="height: 100%;">
    <div class="card" style="margin-top:3.4rem;">


    
        <div class="card-body">
            <h1 class="card-title text-center">Login Page</h1>
            <form method="post" action="<?php echo base_url('/login')?>">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div style="display: flex; justify-content: space-between;">
                <button type="submit" class="btn btn-success btn-block">Submit</button>
                <a href="<?php echo base_url('register')?>" class="d-block mt-3" style="text-decoration: none; color:darkred">Register Here</a>
                </div>
            </form>
        </div>
    </div>
</div>
