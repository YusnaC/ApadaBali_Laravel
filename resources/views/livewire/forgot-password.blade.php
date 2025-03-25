<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($step === 1)
        <div>
            <h3>Reset Password</h3>
            <form wire:submit.prevent="sendVerificationCode">
                <div>
                    <label>Email</label>
                    <input type="email" wire:model="email">
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>
                <button type="submit">Send Verification Code</button>
            </form>
        </div>
    @elseif ($step === 2)
        <div>
            <h3>Enter Verification Code</h3>
            <form wire:submit.prevent="verifyCode">
                <div>
                    <label>Enter 4-digit code</label>
                    <input type="text" wire:model="enteredCode" maxlength="4">
                    @error('enteredCode') <span class="error">{{ $message }}</span> @enderror
                </div>
                <button type="submit">Verify Code</button>
            </form>
        </div>
    @elseif ($step === 3)
        <div>
            <h3>Set New Password</h3>
            <form wire:submit.prevent="resetPassword">
                <div>
                    <label>New Password</label>
                    <input type="password" wire:model="newPassword">
                    @error('newPassword') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label>Confirm New Password</label>
                    <input type="password" wire:model="newPasswordConfirmation">
                </div>
                <button type="submit">Reset Password</button>
            </form>
        </div>
    @endif
</div>
