<a href="{{ route('admin.vendors.show', $id) }}" class="btn btn-primary btn-sm">
    <i class="fas fa-eye"></i>
</a>
<a href="{{ route('admin.vendors.edit', $id) }}" class="btn btn-warning btn-sm">
    <i class="fas fa-pencil-alt"></i>
</a>
<a href="javascript:void(0)" class="btn btn-danger btn-sm" id="delete" data-id="{{ $id }}">
    <i class="fas fa-trash"></i>
</a>