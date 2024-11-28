<form action="{{ route('user.updatePassword', $user->id) }}" method="POST">
    @csrf
    <label for="password">Password Baru:</label>
    <input type="password" name="password" required>
    <button type="submit">Perbarui Password</button>
</form>
