<a href="{{ route('vendor.service.show', $id) }}"><button class="btn btn-info btn-sm" >
    <i class="fas fa-eye"></i>
</button></a>
<a href="{{ route('vendor.service.edit', $id) }}"><button class="btn btn-warning btn-sm" >
    <i class="fas fa-pencil-alt"></i>
</button></a>
<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="delete" data-id="{{ $id }}">
    <i class="fas fa-trash"></i>
</a>