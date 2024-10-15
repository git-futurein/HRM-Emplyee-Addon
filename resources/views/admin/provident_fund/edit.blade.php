<form action="{{ route('provident.fund.update', $data->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="input1" class="form-label">Title</label>
        <input type="text" name="title" value="{{ $data->title }}" class="form-control" id="input1"
            placeholder="Title" required />
    </div>
    <div class="mb-3">
        <label for="input4" class="form-label">Details</label>
        <textarea type="text" name="details" rows="3" class="form-control" id="input3" placeholder="Details">{{ old('details', $data->details) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="input2" class="form-label">Status</label>
        <select name="status" class="form-control" id="input2" required>
            <option value="active" @if ($data->status == 'active') selected @endif> Active </option>
            <option value="inactive" @if ($data->status == 'inactive') selected @endif> Inactive </option>
        </select>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
