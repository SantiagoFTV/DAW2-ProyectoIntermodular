/**
 * Script de gestion de voluntarios
 * Maneja listado local, habilidades y confirmaciones en el cliente
 */
document.addEventListener('DOMContentLoaded', function() {
            // Elementos del DOM
            const volunteerForm = document.getElementById('volunteerForm');
            const volunteersList = document.getElementById('volunteersList');
            const emptyState = document.getElementById('emptyState');
            const skillsContainer = document.getElementById('skillsContainer');
            const skillInput = document.getElementById('skillInput');
            const addSkillBtn = document.getElementById('addSkillBtn');
            const addVolunteerBtn = document.getElementById('addVolunteerBtn');
            const generateScheduleBtn = document.getElementById('generateScheduleBtn');
            const exportDataBtn = document.getElementById('exportDataBtn');
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const confirmModal = document.getElementById('confirmModal');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            const scheduleContainer = document.getElementById('scheduleContainer');
            const scheduleGrid = document.getElementById('scheduleGrid');
            
            // Variables de estado
            let volunteers = JSON.parse(localStorage.getItem('volunteers')) || [];
            let skills = [];
            let editingIndex = -1;
            let volunteerToDelete = -1;
            
            // Inicializar la aplicación
            function init() {
                renderVolunteers();
                updateEmptyState();
            }
            
            // Agregar habilidad
            addSkillBtn.addEventListener('click', function() {
                const skill = skillInput.value.trim();
                if (skill && !skills.includes(skill)) {
                    skills.push(skill);
                    renderSkills();
                    skillInput.value = '';
                }
            });
            
            // Eliminar habilidad
            function removeSkill(index) {
                skills.splice(index, 1);
                renderSkills();
            }
            
            // Renderizar habilidades
            function renderSkills() {
                skillsContainer.innerHTML = '';
                skills.forEach((skill, index) => {
                    const skillTag = document.createElement('div');
                    skillTag.className = 'skill-tag';
                    skillTag.innerHTML = `
                        ${skill}
                        <i class="fas fa-times" onclick="removeSkill(${index})"></i>
                    `;
                    skillsContainer.appendChild(skillTag);
                });
            }
            
            // Guardar voluntario
            volunteerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const name = document.getElementById('name').value;
                const phone = document.getElementById('phone').value;
                const hours = parseInt(document.getElementById('hours').value);
                
                if (skills.length === 0) {
                    alert('Por favor, agrega al menos una habilidad');
                    return;
                }
                
                const volunteer = {
                    name,
                    phone,
                    hours,
                    skills: [...skills]
                };
                
                if (editingIndex === -1) {
                    // Agregar nuevo voluntario
                    volunteers.push(volunteer);
                } else {
                    // Editar voluntario existente
                    volunteers[editingIndex] = volunteer;
                    editingIndex = -1;
                    saveBtn.innerHTML = '<i class="fas fa-save"></i> Guardar';
                }
                
                // Guardar en localStorage
                localStorage.setItem('volunteers', JSON.stringify(volunteers));
                
                // Resetear formulario
                resetForm();
                
                // Actualizar la lista
                renderVolunteers();
                updateEmptyState();
            });
            
            // Cancelar edición
            cancelBtn.addEventListener('click', function() {
                resetForm();
            });
            
            // Resetear formulario
            function resetForm() {
                volunteerForm.reset();
                skills = [];
                renderSkills();
                editingIndex = -1;
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Guardar';
            }
            
            // Editar voluntario
            function editVolunteer(index) {
                const volunteer = volunteers[index];
                document.getElementById('name').value = volunteer.name;
                document.getElementById('phone').value = volunteer.phone;
                document.getElementById('hours').value = volunteer.hours;
                skills = [...volunteer.skills];
                renderSkills();
                editingIndex = index;
                saveBtn.innerHTML = '<i class="fas fa-edit"></i> Actualizar';
            }
            
            // Eliminar voluntario
            function deleteVolunteer(index) {
                volunteerToDelete = index;
                confirmModal.style.display = 'flex';
            }
            
            // Confirmar eliminación
            confirmDeleteBtn.addEventListener('click', function() {
                volunteers.splice(volunteerToDelete, 1);
                localStorage.setItem('volunteers', JSON.stringify(volunteers));
                renderVolunteers();
                updateEmptyState();
                confirmModal.style.display = 'none';
            });
            
            // Cancelar eliminación
            cancelDeleteBtn.addEventListener('click', function() {
                confirmModal.style.display = 'none';
            });
            
            // Renderizar lista de voluntarios
            function renderVolunteers() {
                volunteersList.innerHTML = '';
                
                volunteers.forEach((volunteer, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${volunteer.name}</td>
                        <td>${volunteer.phone}</td>
                        <td>${volunteer.hours} horas</td>
                        <td>${volunteer.skills.join(', ')}</td>
                        <td class="actions">
                            <button class="action-btn edit-btn" onclick="editVolunteer(${index})">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                            <button class="action-btn delete-btn" onclick="deleteVolunteer(${index})">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </td>
                    `;
                    volunteersList.appendChild(row);
                });
            }
            
            // Actualizar estado vacío
            function updateEmptyState() {
                if (volunteers.length === 0) {
                    emptyState.style.display = 'block';
                } else {
                    emptyState.style.display = 'none';
                }
            }
            
            // Generar horario
            generateScheduleBtn.addEventListener('click', function() {
                if (volunteers.length === 0) {
                    alert('No hay voluntarios para generar un horario');
                    return;
                }
                
                scheduleGrid.innerHTML = '';
                
                // Simular generación de horario
                volunteers.forEach(volunteer => {
                    const scheduleCard = document.createElement('div');
                    scheduleCard.className = 'schedule-card';
                    
                    // Generar horario aleatorio para ejemplo
                    const days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
                    const randomDay = days[Math.floor(Math.random() * days.length)];
                    const randomHour = Math.floor(Math.random() * 8) + 8; // Entre 8 y 15
                    
                    scheduleCard.innerHTML = `
                        <h4>${volunteer.name}</h4>
                        <p><strong>Día:</strong> ${randomDay}</p>
                        <p><strong>Horario:</strong> ${randomHour}:00 - ${randomHour + 4}:00</p>
                        <p><strong>Habilidades:</strong> ${volunteer.skills.join(', ')}</p>
                    `;
                    
                    scheduleGrid.appendChild(scheduleCard);
                });
                
                scheduleContainer.style.display = 'block';
            });
            
            // Exportar datos
            exportDataBtn.addEventListener('click', function() {
                if (volunteers.length === 0) {
                    alert('No hay datos para exportar');
                    return;
                }
                
                // Crear contenido CSV
                let csvContent = "Nombre,Teléfono,Horas,Habilidades\n";
                volunteers.forEach(volunteer => {
                    csvContent += `"${volunteer.name}","${volunteer.phone}",${volunteer.hours},"${volunteer.skills.join(', ')}"\n`;
                });
                
                // Crear y descargar archivo
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", "voluntarios.csv");
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
            
            // Cerrar modal al hacer clic fuera
            window.addEventListener('click', function(event) {
                if (event.target === confirmModal) {
                    confirmModal.style.display = 'none';
                }
            });
            
            // Hacer funciones disponibles globalmente para los eventos onclick
            window.editVolunteer = editVolunteer;
            window.deleteVolunteer = deleteVolunteer;
            window.removeSkill = removeSkill;
            
            // Inicializar la aplicación
            init();
        });
