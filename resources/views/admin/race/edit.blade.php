<form action="{{ route('race.update', $data->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="input1" class="form-label">Race Name</label>
        <input type="text" name="name" value="{{ $data->name }}" class="form-control" id="input1"
            placeholder="Relationship Name" required />
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
