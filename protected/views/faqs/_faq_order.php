<?php
$questionList = Faqs::model()->findAll(array('order' => 'faqs_order'));
?>

<div class="view">   

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h3 class="text-green">Set the order for FAQs</h3>
            <hr/>   
            <div id="orderMsg"></div>

            <div class="table-responsive">
                <?php if (!empty($questionList)) { ?>
                    <ul id="sortable">
                        <?php foreach ($questionList as $faq) { ?>
                            <li class="ui-state-default" data="<?php echo $faq->faqs_id; ?>">
                                <i class="fa fa-question-circle"></i> <?php echo $faq->faqs_ques; ?>
                            </li>
                        <?php } ?>
                    </ul>

                    <input type="button" value="Save Order" name="saveOrder" id="saveOrder" class="btn btn-success" />

                <?php } else { ?>
                    <div class="col-md-12">No FAQs Found!</div>
                <?php } ?>
            </div>    
        </div>
    </div>

</div>

<style type="text/css">
    @media (min-width:320px) and (min-width:360px) {
        .view {
            padding: 0 !important;
        }
    }

    @media (min-width:361px){
        .view {
            padding: 0 30px !important;
        }
    }
</style>
<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
    #sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
    html>body #sortable li { height: 1.5em; line-height: 1.2em; }
    .ui-state-highlight { height: 1.5em; line-height: 1.2em; }

    .ui-sortable li {
        height: 32px !important;
        line-height: 22px !important;
        margin: 0 0 10px !important;
        padding: 4px !important;
        cursor: pointer !important;
    }

    .ui-sortable-helper {
        background: rgb(44,62,80) !important;
        color: #fff !important;
    }

</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(function() {
        $("#sortable").sortable({
            placeholder: "ui-state-highlight"
        });
        $("#sortable").disableSelection();

        $('#saveOrder').click(function() {

            var list = [];
            $('#sortable li').each(function(i) {
                list.push(parseInt($(this).attr('data')));
            });

            $.ajax({
                'url': '/faqs/saveOrder',
                data: {list: list},
                type: 'POST',
                success: function(response) {
                    if (response == 1) {
                        $('#orderMsg').removeClass('alert alert-danger');
                        $('#orderMsg').addClass('alert alert-success');                        
                        $('#orderMsg').html('Order saved successfully.');
                    } else {
                        $('#orderMsg').removeClass('alert alert-success');
                        $('#orderMsg').addClass('alert alert-danger');
                        $('#orderMsg').html('Order saved failed. Try again later!');
                    }
                }
            });
        });
    });
</script>