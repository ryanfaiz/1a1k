@extends('layout.main')

@section('content')
    @php $u = $user; @endphp

    <div class="d-flex gap-3 align-items-start mb-4">
        <div style="width:120px;height:120px;border-radius:10px;overflow:hidden;background:#f6f6f6;">
            @if($u->avatar)
                <img src="{{ asset('storage/' . $u->avatar) }}" alt="avatar" style="width:100%;height:100%;object-fit:cover;" />
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&size=256&background=DDDDDD&color=333333" alt="avatar" style="width:100%;height:100%;object-fit:cover;" />
            @endif
        </div>

        <div>
            <h3 class="mb-0">{{ $u->name }}</h3>
            <p class="text-muted mb-1">{{ $u->email }}</p>
            @if($u->bio)
                <p class="small">{{ $u->bio }}</p>
            @endif

            <div class="mt-2">
                <span class="badge" style="background: #38cfc5ff;">Questions: {{ $questionCount }}</span>
                <span class="badge" style="background: #a5cf61ff;">Answers: {{ $answerCount }}</span>

                @auth
                    @if(auth()->id() === $u->id || auth()->user()->role === 'admin')
                        <a href="{{ route('users.export', $u) }}" class="ms-2 btn btn-sm btn-outline-primary">Export CSV</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <canvas id="qaChart" width="400" height="250"></canvas>
        </div>

        <div class="col-md-6">
            <h5>Recent Questions</h5>
            <table id="questionsTable" class="table table-striped table-sm">
                <thead><tr><th>ID</th><th>Title</th><th>Created</th></tr></thead>
                <tbody>
                @foreach($questions as $q)
                    <tr>
                        <td>{{ $q->id }}</td>
                        <td><a href="{{ route('qna.show', $q->id) }}">{{ $q->title }}</a></td>
                        <td>{{ $q->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <h5 class="mt-4">Recent Answers</h5>
            <table id="answersTable" class="table table-striped table-sm">
                <thead><tr><th>ID</th><th>For Question</th><th>Created</th></tr></thead>
                <tbody>
                @foreach($answers as $a)
                    <tr>
                        <td>{{ $a->id }}</td>
                        <td>
                            @if($a->question)
                                <a href="{{ route('qna.show', $a->question->id) }}">{{ 
                                    Str::limit($a->question->title, 60) }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $a->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(function(){
            $('#questionsTable').DataTable({"pageLength":5});
            $('#answersTable').DataTable({"pageLength":5});

            const ctx = document.getElementById('qaChart').getContext('2d');
            const qaChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Questions','Answers'],
                    datasets: [{
                        label: 'Count',
                        data: [{{ $questionCount }}, {{ $answerCount }}],
                        backgroundColor: ['#38cfc5ff','#a5cf61ff']
                    }]
                },
                options: {responsive:true,maintainAspectRatio:false}
            });
        });
    </script>
@endsection
