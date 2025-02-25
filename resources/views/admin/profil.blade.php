<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="profile-card p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img src="https://via.placeholder.com/80" alt="Profile" class="profile-img me-3">
                        <div>
                            <h5 class="mb-0">{{Auth::user()->name }}</h5>
                            <p class="text-muted small">{{Auth::user()->email }}</p>
                        </div>
                        <button class="btn btn-primary ms-auto">Edit</button>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="Your First Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nick Name</label>
                            <input type="text" class="form-control" placeholder="Your Nick Name">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select">
                                <option selected>Select Gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Country</label>
                            <select class="form-select">
                                <option selected>Select Country</option>
                                <option>USA</option>
                                <option>Canada</option>
                                <option>UK</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Language</label>
                            <input type="text" class="form-control" placeholder="Your Language">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Time Zone</label>
                            <select class="form-select">
                                <option selected>Select Time Zone</option>
                                <option>GMT</option>
                                <option>PST</option>
                                <option>EST</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6>My Email Address</h6>
                        <p class="text-muted"><i class="bi bi-envelope-fill"></i> alexarawles@gmail.com <span class="small">(1 month ago)</span></p>
                        <button class="btn btn-outline-primary btn-sm">+ Add Email Address</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>