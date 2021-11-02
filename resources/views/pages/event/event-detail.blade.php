@extends('layouts.main')
@section('content')

<div class="col-md-12">
    <form action="">    
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <div class="row mb-2 ">
                            <div class="col-md-2">Code</div>
                            <div class="col-md-8"><input type="text" class="form-control" placeholder=""></i></div>
                            <div class="col-auto"><i class="fas fa-edit"></i></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-2">Event</div>
                            <div class="col-md-8"><input type="text" class="form-control" placeholder=""></div>
                            <div class="col-auto"><i class="fas fa-edit"></i></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-auto">Note</div>
                            <div class="col-md-10"><textarea name="formula" id="formula" cols="20" rows="5" class="form-control" ></textarea></div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 ">
                    <div class="col-md-auto">Formula</div>
                    <div class="col-md-10"><input type="text" class="form-control" style="height: 100px;" placeholder=""></div>
                </div>

                <div class="row mb-3 m-3 ">
                    <div class="col-md-6">
                        <input type="text" class="form-control mb-2" placeholder="">
                        <select class="form-select mb-3" size="5" aria-label="size 3 select example">
                            <option selected>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                            <option value="3">Three</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <textarea name="" id="" cols="10" rows="6" class="form-control" >
                            GetSomethingTwo
                            Little explanation about what GetSomethingTwo does or function
                        </textarea>
                    </div>

                </div>
                <div class="row">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary rounded-xl"  style="background-color: #707070;color:white;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Test</button>
                        <button class="btn btn-md rounded-xl" style="background-color:#CCCCCC; color:white" >Close</button>
                        <button class="btn btn-md bg-info rounded-xl" style="color:white" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

  
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Testing</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control mb-2" placeholder="Event Name">
            <input type="text" class="form-control mb-2" placeholder="Formula" style="height:200px">
        </div>
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Result/Notes</h5>
          
        </div>
        <div class="modal-body">
            <input type="text" class="form-control mb-2" placeholder="" style="height: 100px">
        </div>
    
        <div class="modal-footer">
          <button type="button" class="btn btn-md rounded-xl" style="background-color:#CCCCCC; color:white" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection

