@extends('layout')

@section('title', 'Fournisseurs')

@section('content')

@if (session()->has('success_message'))
  <div class="alert alert-success">
    {{ session()->get('success_message') }}
  </div>
@endif

<div class="ajouter-fournisseur-btn" style="margin-bottom:15px">
  <a href="{{route('fournisseur.create')}}" class="btn btn-primary">Ajouter un fournisseur</a>
</div>

<table id="fournisseurs_table" class="display" style="width:100%">
  <thead>
      <tr>
          <th></th>
          <th>Code</th>
          <th>Nom</th>
          <th>Code Postal</th>
          <th>Ville</th>
          <th>Pays</th>
          <th></th>
      </tr>
  </thead> 
</table>

@endsection

@section('extra-js')
  <script>

    (function(){

      /* Formatting function for row details - modify as you need */
      function format(data) {
        
        let adresses = '';

        const adresses_count = 4;

        if(data.adresses){
          
          for (let i = 1; i <= adresses_count; i++) {
            
            const element = data.adresses[i - 1];
            
            const value = element ? element.adresse : '';
             
            const id = element ? element.id : "";

            adresses += `<input class="adresse-input" data-id="${id}"
                          type="text" name="adresse_${i}" value="${value}">`; 
            
          }

        }
        
        const newData = Object.assign({}, data);

        newData['adresses'] = adresses;
        
        return newData;
      }

      $(document).ready(function() {
      var table = $('#fournisseurs_table').DataTable( {
          "ajax": "/fournisseurs/get-data",
          "columns": [
              {
                  "className":      'details-control',
                  "orderable":      false,
                  "data":           null,
                  "defaultContent": ''
              },
              { "data": "id" }, 
              { "data": "Nom" },
              { "data": "cp" },
              { "data": "Ville" },
              { "data": "Pays" },
              { "data" : "id", 
                render : function(data, type, row){
                  return `<form action="/fournisseurs/${data}/destroy" 
                          method="post" data-id=${data} class="destroy-form">
                          @csrf
                          @method('delete')
                            <button type="submit" class="fournisseur-delete-icon">
                              <i class='fa fa-trash fournisseur-delete-icon'></i>
                            </button>
                          </form>`;
                } 
              }
          ],
          "order": [[1, 'asc']]
      } );

      // Add event listener for opening and closing details
      $('#fournisseurs_table tbody').on('click', 'td.details-control', function () {
        
          var tr = $(this).closest('tr');
          var row = table.row( tr );
          
          if ( row.child.isShown() ) {
              // This row is already open - close it
              row.child.hide();
              tr.removeClass('shown');
          }
          else {

              const data = row.data();
              const fournisseur_id = tr.find('form.destroy-form').data('id');
                
              //Get childrow HTML
              $.ajax({
                type: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/fournisseurs/${fournisseur_id}/ajax/childrow`,
                data: data,
                success:function(response) {
                  // Open this row
                  row.child( response ).show();
                  tr.addClass('shown'); 
                },
                error:function(e){
                  console.log(e);
                  
                }
              });
          }
        } );

        // Add event listener for fournisseur update
        document.body.addEventListener('click', e => {
          
          if(e.target.classList.contains('modifier-fournisseur-btn')){

            const modifier_btn = e.target;
            const fournisseur_id = modifier_btn.dataset['id'];
            const form = modifier_btn.closest('form');
            let data = $(form).serializeArray();
            
            const adresses_count = 4;

            let adresses_html = '';

            for (let i = 1; i <= adresses_count; i++) {
              
              const adresse_id = $(`input[name="adresse_${i}"]`, form).data('id') || '';
              data.push( {name : "adresse_id_" + i, value : adresse_id} );
              
            }

            var tr = $('tr.odd.shown');
            var row = table.row( tr );
            
            //Update fournisseur
            $.ajax({
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: `/fournisseurs/${fournisseur_id}/update`,
              data: data,
              success:function(response) {

                const success_message = JSON.parse(response)['success_message'];
                $('.fournisseurs-errors').hide();
                $('.fournisseurs-success').show()
                .text(success_message);
                 
              },
              error:function(e){
                
                const errors_messages = JSON.parse(e.responseText);
                $('.fournisseurs-success').hide();
                $('.fournisseurs-errors').show().find('ul').empty();

                for (const key in errors_messages) {
                  if (errors_messages.hasOwnProperty(key)) {
                    const error_message = errors_messages[key];
                    $('.fournisseurs-errors ul')
                    .append( $(`<li>${error_message}</li>`) );
                  }
                }

              }
            });
            
          }
          
        })


        //delete fournisseur
        document.addEventListener('click', e => {

          const element = e.target;

          if(element.classList.contains('fournisseur-delete-icon')){
                        
            e.preventDefault();

            if(confirm('Voulez vous vraiment supprimer ce fournisseur ?')){
              element.closest('form').submit(); 
            }
                      
          }

        });


        //Add contact
        document.addEventListener('click', e => {

        const element = e.target;

        if(element.classList.contains('ajouter-contact')){
              
          const btn = e.target;            
          const fournisseur_id = btn.dataset['id'];   
          const form = btn.closest('form');
          const data = $(form).serializeArray();  

          $(form).find('input').val('');

          $.ajax({
            type: "POST",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/fournisseurs/${fournisseur_id}/contact/store`,
            data: data,
            success:function(response) {
              response = JSON.parse(response);
              const success_message = response['success_message'];
              const contact_html = response['html'];
              $('.contact-errors').hide();
              $('.contact-success').show()
              .text(success_message);

              $('.ajouter-contact-btn').parent().find('.contacts-container tbody')
              .append(contact_html);
                
            },
            error:function(e){
              
              const errors_messages = JSON.parse(e.responseText);
              
              $('.contact-success').hide();
              $('.contact-errors').show().find('ul').empty();

              for (const key in errors_messages) {
                if (errors_messages.hasOwnProperty(key)) {
                  const error_message = errors_messages[key];
                  $('.contact-errors ul')
                  .append( $(`<li>${error_message}</li>`) );
                }
              }

            }
          });

        }

        });

        //update contact
        document.body.addEventListener('click', function(e){

          if(e.target.classList.contains('modifier-contact')){

          const contact_form = $('form.modifier-contact-form');  
          const contact_id = contact_form.data('id');
          const data = contact_form.serializeArray();
          
          $.ajax({
            type: "post",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/fournisseurs/contact/${contact_id}/update`,
            data : data,
            success:function(response) {

              const success_message = JSON.parse(response)['success_message'];
              $('.contact-errors').hide();
              
              //replace old contact row with new one
              $.ajax({
                type: "GET",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/fournisseurs/ajax/${contact_id}/contactrow`,
                success:function(response) {
                  $('.contact-success').show()
                  .text(success_message);
                  
                  const old_row = $('table.contact-table tbody tr[data-id="' + contact_id +'"]');
                  const contact_row = response;
                  old_row.replaceWith(contact_row);
                },error:function(e){

                }
              });
                
            },
            error:function(e){
              console.log(e.responseText);
              
              const errors_messages = JSON.parse(e.responseText);
              $('.contact-success').hide();
              $('.contact-errors').show().find('ul').empty();

              for (const key in errors_messages) {
                if (errors_messages.hasOwnProperty(key)) {
                  const error_message = errors_messages[key];
                  $('.contact-errors ul')
                  .append( $(`<li>${error_message}</li>`) );
                }
              }

            }
          });
        }
        });

        //delete contact
        document.addEventListener('click', e => {

          const element = e.target;
           
          if(element.classList.contains('contact-delete-icon')){
            
          const contact_row = $(element.closest('tr'));
          const contact_id = contact_row.data('id');
                      
            if(confirm('Voulez vous vraiment supprimer ce contact ?')){

              $.ajax({
                type: "POST",
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `/contact/destroy/${contact_id}`,
                success:function(response) {
                  const success_message = JSON.parse(response)['success_message'];
                  $('.contact-errors').hide();
                  $('.contact-success').show()
                  .text(success_message);
                  contact_row.remove();
                },
                error:function(e){
                  
                }
              }); 

            }
                      
          }

        });

      //document ready end   
      } );


    })();

  </script>
@endsection