
<!-- Vendor JS Files -->
<script src="{{asset('back/dist/js/dropzone.min.js')}}"></script>
<script src="{{url('front/js/app.js')}}"></script>
{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>--}}
<script src="{{asset('front/assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
@yield('js')
<script type="text/javascript">
    $(".portfolio-item").click(function(){
        $('.portfolio-info').css('display', 'block').show('slow');
    })
</script>
<script type="text/javascript">
    $(function () {
        $("#catorderselect").change(function() {
            var val = $(this).val();
            if(val === "12") {
                $("#showcatorder").css('display', 'block').show('slow');
            }
            else {
                $("#showcatorder").css('display', 'none').hide('slow');
            }
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $("#show-sidebar-menu").click(function () {
            $("#sidebar-menu").css('display','block');
        });
        $("#close-sidebar-menu").click(function () {
            $("#sidebar-menu").css('display','none');
        });
    });
</script>
<script type="text/javascript">
    $(function () {
        $(".coin-home").mouseover(function () {
            $(".coin-tooltip").css('display','block');
        });
        $(".coin-home").mousedown(function () {
            $(".coin-tooltip").css('display','none');
        });
    });
</script>
<script>
    Dropzone.autoDiscover = false;
    var photosGallery = []
    var drop = new Dropzone('#photo' , {
        acceptedFiles: 'image/jpeg,image/jpg,image/png,.jpeg,.jpg,.png',
        addRemoveLinks : true,
        url : "{{route('photos.upload')}}",
        sending : function (file ,xhr ,formData) {
            formData.append("_token" , "{{csrf_token()}}")
        },
        success: function (file, response){
            photosGallery.push(response.photos)
        }
    });
    productGallery = function () {
        document.getElementById('pro-photo').value = photosGallery
    }
</script>
<script>
    var x, i, j, l, ll, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("form-control-customize");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < ll; j++) {
            /*for each option in the original select element,
            create a new DIV that will act as an option item:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /*when an item is clicked, update the original select box,
                and the selected item:*/
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /*when the select box is clicked, close any other select boxes,
            and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }
    function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
        except the current select box:*/
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }
    /*if the user clicks anywhere outside the select box,
    then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);
</script>
<script>
    $(document).ready(function(){
        $('#fail').on('click',function(){
            $('#fail h1,#fail p,#fail .fail').css({display:'none'});

            $('#fail').animate({
                width:'0',
            },250,function(){
                $('#fail .icon').animate({
                    borderRadius:'50%',
                },250,function(){

                    $('#fail .icon').animate({
                        opacity:0
                    },250);
                });
            });
        });
        $('.succ').on('click',function(){
            $('#success h1,#success p,#success .succ').css({display:'none'});

            $('#success').animate({
                width:'0',
            },250,function(){
                $('#success .icon').animate({
                    borderRadius:'50%',
                },250,function(){

                    $('#success .icon').animate({
                        opacity:0
                    },250);
                });
            });
        });
        $('button').on('click',function(){
            $('section').css({width:'400px'});
            $('section h1,section p,section i').css({display:'block'});
            $('section .icon').css({
                borderRadius:'0',
                opacity:1
            })
        });
    });

</script>

</body>

</html>
