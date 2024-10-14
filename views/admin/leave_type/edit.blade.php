<form action="{{ route('leave.type.update', $data->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="input1" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $data->title) }}" id="input1"
            placeholder="Title" required />
    </div>
    <div class="mb-3">
        <label for="input2" class="form-label">paid_Status</label>
        <select name="paid_status" class="form-control" id="input2" required>
            <option value="paid" @if ($data->paid_status == 'paid') selected @endif> Paid </option>
            <option value="unpaid" @if ($data->paid_status == 'unpaid') selected @endif> Unpaid </option>
        </select>
    </div>
    <div class="mb-3">
        <label for="input4" class="form-label">Remarks</label>
        <textarea type="text" name="remarks" class="form-control" id="input3" placeholder="Remarks">{{ old('remarks', $data->remarks) }}</textarea>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
