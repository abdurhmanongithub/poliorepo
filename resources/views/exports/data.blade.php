<table class="table table-sm table-bordered">
    <thead>
        <tr>
            @foreach ($headings as $heading)
                <th scope="col" style="background-color: #0067b8;color:#ffffff;">{{ $heading }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $data)
            <tr>
                @foreach ($data as $item)
                    <td>{{ $item }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
