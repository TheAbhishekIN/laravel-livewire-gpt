<div>
    @foreach($messages as $message)
        @if($message['role'] !== 'system')
            <div class="flex rounded-lg p-4 m-2 @if ($message['role'] === 'assistant') bg-green-200 flex-reverse @else bg-blue-200 @endif ">
                <div class="ml-4">
                    <div class="text-lg">
                        @if ($message['role'] === 'assistant')
                            <a href="#" class="font-medium text-gray-900">LaravelGPT</a>
                        @else
                            <a href="#" class="font-medium text-gray-900">You</a>
                        @endif
                    </div>
                    <div class="mt-1">
                        <p class="text-gray-600">
                            {!! \Illuminate\Mail\Markdown::parse($message['content']) !!}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <form class="p-4 flex space-x-4 justify-center items-center" wire:submit.prevent="saveQuestion">
        <label for="message">Laravel Question:</label>
        <input id="message" type="text" wire:model="question" autocomplete="off" class="border rounded-md  p-2 flex-1" />
        <button class="bg-blue-800 text-white p-2 rounded-md" type="submit">
            <div wire:loading.saveQuestion.remove wire:target="saveQuestion">
                Submit
            </div>
            <div wire:loading wire:target="saveQuestion">
                loading ....
            </div>
        </button>
        <button wire:click.prevent="resetSession" class="bg-gray-800 text-white p-2 rounded-md" type="submit">Reset</button>
    </form>
</div>
