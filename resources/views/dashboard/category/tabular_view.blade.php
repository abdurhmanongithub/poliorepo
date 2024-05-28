<!--begin::Table-->
<div class="table-responsive">
    <table class="table table-borderless table-vertical-center">
        <thead>
            <tr>
                <th class="p-0" style="width: 50px"></th>
                <th class="p-0" style="min-width: 100px"></th>
                <th class="p-0" style="min-width: 140px"></th>
                <th class="p-0" style="min-width: 120px"></th>
                <th class="p-0" style="min-width: 120px"></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($categoryStats ?? [] as $categoryStat)
                <tr>
                    <td class="pl-0 py-5">
                        <div class="symbol symbol-50 symbol-light mr-2">
                            <span class="symbol-label">
                                @include('svg.briefcase')
                            </span>
                        </div>
                    </td>
                    <td class="pl-0">
                        <a href="#"
                            class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-sm">{{ $categoryStat['name'] }}</a>
                        <span class="text-muted font-size-sm d-block">{{ $categoryStat['sub_category_count'] }} Sub
                            categories</span>
                    </td>
                    <td class="text-right">
                        <span
                            class="badge badge-secondary font-size-sm">{{ number_format($categoryStat['schema_count'], 0, '.', ',') }}
                            Schemas</span>
                    </td>
                    <td class="text-right">
                        <span
                            class="badge badge-danger font-size-sm">{{ number_format($categoryStat['missing_values'], 0, '.', ',') }}
                            Missing Values</span>
                    </td>
                    <td class="text-right">
                        <span
                            class="badge badge-primary font-size-sm">{{ number_format($categoryStat['data_count'], 0, '.', ',') }}
                            Data</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!--end::Table-->
