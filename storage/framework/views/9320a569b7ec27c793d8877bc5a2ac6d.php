<?php $__env->startSection('title'); ?> Produção por exame <?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <body data-topbar="dark" data-layout="horizontal">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('title'); ?> Produção por exame <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
        <?php $__env->slot('li_2'); ?> Produção por exame <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row"> 

        <div class="col-xl-12">
            <input type="hidden" value="<?php echo e(url('/')); ?>" data-base-url>
            <div class="alert alert-warning" style="display: none" data-alert></div>

            <div class="card p-3 mb-3">
                <form action="<?php echo e(route('routine.production.by.exam.search.all')); ?>" method="POST" data-form-production-exam>
                    <?php echo csrf_field(); ?>
                    <div class="d-md-flex">
                        <div class="col-md-3 mb-4">
                            <label class="form-label">Data inicial</label>
                            <input type="date" class="form-control" data-started-at>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="form-label">Data final</label>
                            <input type="date" class="form-control" data-finished-at>
                        </div>
                        <div class="col-md-2 mb-4">
                            <label class="form-label invisible">.</label>
                            <button type="submit" class="btn btn-primary form-control" data-submit-production-exam>
                                <i class="fa fa-search"></i>
                                <span class="ml-2">Buscar</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div data-container style="display: none;">
                    <div data-content></div>
                    <a href="" class="btn btn-dark mx-3 mt-3 d-none" target="_blank" data-print-production-exam>
                        Gerar relatório
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/js/pages/routine/production-by-exam.js')); ?>?version=160320252122"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-layouts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u444904474/domains/sislac.com.br/public_html/coremas.sislac.com.br/resources/views/routine/production-by-exam/index.blade.php ENDPATH**/ ?>