@foreach($AdminData['datatableData']['columnList'] as $column)
    { data : '{{ $column->selectColumnName }}', name : '{{ $column->columnName }}', className : '{{ $column->className }}', orderable :@if($column->orderable == true) true @else false @endif, searchable : @if($column->searchable == true) true @else false @endif },
@endforeach