<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Order;

class UserManagement extends Component
{
    public $showModal = false;      // Controls add/edit modal visibility
    public $showDeleteModal = false;// Controls delete modal visibility
    public $userId;                 
    public $username;
    public $email;
    public $password;
    public $membership_plan;
    public $status;
    public $userToDelete;           // Holds the user being deleted

    // Dynamic validation rules
    protected function rules()
    {
        return [
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => $this->userId
                ? 'nullable|string|min:6'
                : 'required|string|min:6',
            'membership_plan' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function openModal($userId = null)
    {
        $this->resetForm();

        if ($userId) {
            $user = User::findOrFail($userId);
            $this->userId = $user->id;
            $this->username = $user->username;
            $this->email = $user->email;
            $this->membership_plan = $user->membership_plan;
            $this->status = $user->status;
            // leave password empty so we don’t double hash
            $this->password = '';
        } else {
            $this->status = 'active'; // default for new users
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function saveUser()
    {
        $this->validate();

        $data = [
            'username' => $this->username,
            'email' => $this->email,
            'membership_plan' => $this->membership_plan,
            'status' => $this->status,
        ];

        // Only hash & update password if provided
        if (!empty($this->password)) {
            $data['password'] = bcrypt($this->password);
        }

        User::updateOrCreate(['id' => $this->userId], $data);

        $this->closeModal();
        session()->flash('success', 'User saved successfully!');
    }

    private function resetForm()
    {
        $this->userId = null;
        $this->username = '';
        $this->email = '';
        $this->password = '';
        $this->membership_plan = '';
        $this->status = 'active';
    }

    public function confirmDelete($id)
    {
        $this->userToDelete = User::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteConfirmed()
    {
        if ($this->userToDelete) {
            $hasOrders = Order::where('user_id', $this->userToDelete->id)->exists();

            if ($hasOrders) {
                // mark inactive if user exists in past records
                $this->userToDelete->update(['status' => 'inactive']);
                session()->flash(
                    'error',
                    'Cannot delete this user because they exist in past records. They have been marked as inactive.'
                );
            } else {
                $this->userToDelete->delete();
                session()->flash('success', 'User deleted successfully!');
            }
        }

        $this->showDeleteModal = false;
        $this->userToDelete = null;
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => User::where('role', '!=', 'admin')
                ->orderBy('id', 'desc')
                ->paginate(5),
        ]);
    }
}