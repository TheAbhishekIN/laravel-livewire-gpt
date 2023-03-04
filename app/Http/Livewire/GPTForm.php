<?php

namespace App\Http\Livewire;

use Livewire\Component;
use OpenAI\Laravel\Facades\OpenAI;

class GPTForm extends Component
{

    public $messages;
    public $question;

    public function mount(){
        $this->messages = collect(session('messages', []))->reject(fn ($message) => $message['role'] === 'system');
    }

    public function render()
    {
        $messages = $this->messages;
        return view('livewire.g-p-t-form', compact('messages'))->layout('welcome');
    }

    public function saveQuestion(){

        $this->messages = request()->session()->get('messages', [
            ['role' => 'system', 'content' => 'You are LaravelGPT - A ChatGPT clone. Answer as concisely as possible.']
        ]);
        
        $this->messages[] = ['role' => 'user', 'content' => $this->question];

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $this->messages
        ]);

        $this->messages[] = ['role' => 'assistant', 'content' => $response->choices[0]->message->content];
    
        request()->session()->put('messages', $this->messages);

        $this->question = '';
    }

    public function resetSession(){
        request()->session()->forget('messages');
        $this->messages = [];
    }
}
