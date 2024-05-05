<x-layout>
  <x-card class="p-10 max-w-lg mx-auto mt-24">
      <form id="dealerForm">
          <header class="text-center">
              <h2 class="text-2xl font-bold uppercase mb-1">Become an approved partner</h2>
              <p class="mb-4">Contact us to potentially start a collaboration.</p>
          </header>
          <div class="mb-6">
              <label for="name" class="inline-block text-lg mb-2">Your Name</label>
              <input type="text" class="border border-gray-200 rounded p-2 w-full" name="name" id="name" required>
          </div>
          <div class="mb-6">
              <label for="message" class="inline-block text-lg mb-2">Message</label>
              <textarea name="message" id="message" class="border border-gray-200 rounded p-2 w-full" rows="4" required></textarea>
          </div>
          <button type="button" onclick="sendWhatsApp();" class="bg-green-500 text-white rounded py-2 px-4 hover:bg-green-600">
              Send via WhatsApp
          </button>
      </form>
  </x-card>
</x-layout>

<script>
    function sendWhatsApp() {
        var name = document.getElementById('name').value;
        var message = document.getElementById('message').value;
        var fullMessage = encodeURIComponent("Hello, my name is " + name + ". I am interested in becoming a dealer. Here is my message: " + message);
    
        var whatsappUrl = `https://wa.me/+32491280944?text=${fullMessage}`;
        window.open(whatsappUrl, '_blank');
    }
    </script>
    
