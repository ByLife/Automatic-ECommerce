document.addEventListener('DOMContentLoaded', async () => {
    document.querySelectorAll('.server-delete').forEach((button) => {
        button.addEventListener('click', async (e) => {
            e.preventDefault()
            try{
                const response = await fetch("./api/admin/services", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        token : getCookie('token'),
                        server_id: e.target.value,
                        type: 'delete',
                    }),
                })
                const data = await response.json()
                if (data.status == 'success') {
                   e.target.parentElement.parentElement.parentElement.remove()
                   console.log(data)
                } else {
                    console.log(data)
                }
            } catch (e) {
                console.log(e)
            }
        })
    })

    document.querySelector('.btn-plan').addEventListener('click', async (e) => {
        try{
            e.preventDefault()

            var planModal = {
                "name" : document.querySelector('.plan_name').value,
                "price" : document.querySelector('.plan_price').value,
                "description" : document.querySelector('.plan_description').value,
                "ram" : document.querySelector('.plan_ram').value,
                "cpu_core" : document.querySelector('.plan_cpu_core').value,
                "disk_space" : document.querySelector('.plan_disk_space').value,
                "bandwidth" : document.querySelector('.plan_bandwidth').value,
            }
            
            console.log(planModal)

            const response = await fetch("./api/admin/services", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    token : getCookie('token'),
                    name: planModal.name,
                    price: planModal.price,
                    description: planModal.description,
                    ram: planModal.ram,
                    cpu_core: planModal.cpu_core,
                    disk_space: planModal.disk_space,
                    bandwidth: planModal.bandwidth,
                    type: 'create_plan',
                }),
            })
            const data = await response.json()
            if (data.status == 'success') {
               document.querySelector('.alert-container').innerHTML = `
                <div class="alert alert-success" role="alert">
                    <strong>Success!</strong> Plan added !
                </div>
                `
            } else {
                document.querySelector('.alert-container').innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <strong>Error!</strong> ${data.message}
                </div>
                `;
            }
        } catch (e) {
            console.log(e)
        }
    })
})
