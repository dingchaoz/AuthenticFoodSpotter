
<?php Debugbar::disable(); ?>
@foreach($sub_categories as $sub_category)
<option value="{{$sub_category->id}}"> {{$sub_category->sub_category}}</option>
@endforeach