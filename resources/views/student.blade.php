<!doctype html>
<html lang="en">

<head>
    <title>Student Detail</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div id="div" class="row h-100 d-flex align-items-center justify-content-center" style="padding:6%;">
        <table class="table">
            <h4>Student Details</h4>
        </table>

        @if (\Session::has('error'))
            <ul id="ul">
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        @endif

        <form action="" class="w-100">
            <div class="input-group mb-3">
                <input type="search" class="form-control" placeholder="Search" name="search">
                <div class="input-group-append">
                    <button class="btn btn-dark">Search</button>
                </div>
            </div>
        </form>


        <div class="table table-responsive table-hover" style="width:100%">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">City</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $size = sizeof($students);    
                    ?>
                    @if ($size == 0)
                        <td>No Record Found!</td>
                    @else
                        @foreach ($students as $student)
                            <tr>
                                <th scope="row">{{ $student->id }}</th>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->city }}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>

        </div>



        <div class="row">
            <div class="d-flex justify-content-center">
                {{ $students->links() }}
            </div>
        </div>






    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
