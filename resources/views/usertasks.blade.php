@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center font-weight-bold">Мои заявки</h4>
                        <table id="task_list_table" class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Заголовок</th>
                                <th scope="col">Текст</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            axios.get('tasks').then(r => {
                console.log(r);
            })
        });
    </script>
@endpush
