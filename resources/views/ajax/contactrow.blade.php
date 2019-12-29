<tr data-id="{{$contact['id']}}">
  <td>{{$contact['Nom']}}</td>
  <td>{{$contact['Prenom']}}</td>
  <td>{{$contact['Tel']}}</td>
  <td>{{$contact['Fax']}}</td>
  <td>{{$contact['Mail']}}</td>
  <td>{{$contact['Adresse']}}</td>
  <td> 
    <a href="/fournisseurs/ajax/{{$contact['id']}}/contactform" rel="modal:open">
      <i class="fa fa-edit contact-edit-icon" style="margin-right:15px"></i>
    </a> 
    <i class="fa fa-trash contact-delete-icon"></i> 
  </td>
</tr>