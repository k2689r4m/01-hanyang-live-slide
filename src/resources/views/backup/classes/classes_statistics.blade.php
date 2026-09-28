<table class="table text-center">
    <thead class="thead-dark">
    <tr>
        <th scope="col">번호</th>
        <th scope="col">수업명</th>
        <th scope="col">생성일</th>
        <th scope="col">슬라이드 수</th>
        <th scope="col">참여자 수</th>
    </tr>
    </thead>
    <tbody>
    @foreach($classes as $class)
    <tr>
        <th scope="row">{{ $class['id'] }}</th>
        <td>{{ $class['name'] }}</td>
        <td>{{ $class['created_at'] }}</td>
        <td>test</td>
        <td>test</td>
    </tr>
    @endforeach
    </tbody>
</table>
