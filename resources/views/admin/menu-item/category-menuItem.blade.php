@if(!blank($menuItems))
    <option value="">Select Menu item</option>
    @foreach($menuItems as $menuItem)
        <option  value="{{ $menuItem->id }}"> {{ $menuItem->name }} ( {{ $menuItem->unit_price }} )</option>
        @endforeach
    @endif
