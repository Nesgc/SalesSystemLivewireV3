<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('scan-ok', Msg => {
            noty(Msg)
        })

        @this.on('scan-notfound', Msg => {
            noty(Msg, 2)
        })

        @this.on('no-stock', Msg => {
            noty(Msg, 2)
        })

        @this.on('sale-error', Msg => {
            noty(Msg)
        })

        @this.on('print-ticket', saleId => {
            window.open("print://" + saleId, '_blank')
        })

    });
</script>
