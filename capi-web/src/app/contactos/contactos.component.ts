import { Component, OnInit } from '@angular/core';
import { ContactosService } from '../../services/contactos/contactos.service';
import { TableModule } from 'primeng/table';
import {
  Contacto,
  Direcciones,
  Emails,
  Telefonos,
} from '../../domain/contactos.model';
import { IconFieldModule } from 'primeng/iconfield';
import { InputIconModule } from 'primeng/inputicon';
import { InputTextModule } from 'primeng/inputtext';
import { ButtonModule } from 'primeng/button';
import { SpeedDialModule } from 'primeng/speeddial';
import { DialogModule } from 'primeng/dialog';
import { FormsModule } from '@angular/forms';
import { CalendarModule } from 'primeng/calendar';
import { FloatLabelModule } from 'primeng/floatlabel';
import { StepsModule } from 'primeng/steps';
import { ConfirmationService, MenuItem } from 'primeng/api';
import { AppDatosPersonalesComponent } from './datos-personales/datos-personales.component';
import { AppTelefonosComponent } from './telefonos/telefonos.component';
import { CommonModule } from '@angular/common';
import { AppEmailsComponent } from './emails/emails.component';
import { AppDireccionesComponent } from './direcciones/direcciones.component';
import { ToastModule } from 'primeng/toast';
import { MessageService } from 'primeng/api';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { PaginatorModule } from 'primeng/paginator';

@Component({
  selector: 'app-contactos',
  standalone: true,
  imports: [
    AppDatosPersonalesComponent,
    AppTelefonosComponent,
    AppEmailsComponent,
    AppDireccionesComponent,
    TableModule,
    IconFieldModule,
    InputIconModule,
    InputTextModule,
    ButtonModule,
    SpeedDialModule,
    DialogModule,
    FormsModule,
    CalendarModule,
    FloatLabelModule,
    StepsModule,
    CommonModule,
    ToastModule,
    ConfirmDialogModule,
    PaginatorModule,
  ],
  providers: [MessageService, ConfirmationService],
  templateUrl: './contactos.component.html',
  styleUrl: './contactos.component.css',
})
export class ContactosComponent implements OnInit {
  contactos!: Contacto[];
  loading = true;
  visible: boolean = false;
  contacto: Contacto = {};
  telefonos: Telefonos[] = [];
  emails: Emails[] = [];
  direcciones: Direcciones[] = [];
  items: MenuItem[] | undefined;
  activeIndex: number = 0;
  page = 1;
  limit = 20;
  first = 0;
  query = '';
  totalRecords: number = 0;
  update: boolean = false;
  view: boolean = false;

  constructor(
    private contactosService: ContactosService,
    private messageService: MessageService,
    private confirmationService: ConfirmationService
  ) {}

  ngOnInit() {
    this.obtenerInformacion();

    this.items = [
      {
        label: 'Datos Personales',
        command: (event: any) => {
          this.activeIndex = 0;
        },
      },
      {
        label: 'Telefonos',
        command: (event: any) => {
          this.activeIndex = 1;
        },
      },
      {
        label: 'Emails',
        command: (event: any) => {
          this.activeIndex = 2;
        },
      },
      {
        label: 'Direcciones',
        command: (event: any) => {
          this.activeIndex = 3;
        },
      },
    ];
  }

  onPageChange(page: any) {
    this.first = page.first;
    this.page = page.page;
    this.limit = page.rows;
    this.obtenerInformacion();
  }

  onQueryChange() {
    if (this.query === '') {
      this.page = 1;
      this.limit = 20;
      this.obtenerInformacion();
    }

    if (this.query.length > 2) {
      this.contactosService
        .getContactos(this.query, this.page, this.limit)
        .subscribe((contactos: any) => {
          this.contactos = contactos?.data?.data ?? [];
        });
    }
  }

  onActiveIndexChange(event: number) {
    this.activeIndex = event;
  }

  deleteContacto(id: number) {
    this.confirmationService.confirm({
      header: 'Eliminar Contacto',
      icon: 'pi pi-info-circle',
      acceptButtonStyleClass: 'p-button-danger p-button-text',
      rejectButtonStyleClass: 'p-button-text p-button-text',
      acceptIcon: 'none',
      rejectIcon: 'none',
      message: '¿Estas seguro de eliminar este contacto?',
      accept: () => {
        this.contactosService.deleteContacto(id).subscribe(() => {
          this.contactos = this.contactos.filter(
            (contacto) => contacto.id !== id
          );
          this.messageService.add({
            severity: 'success',
            summary: 'Success',
            detail: 'Contacto eliminado correctamente',
          });
        });
      },
      reject: () => {
        this.messageService.add({
          severity: 'info',
          summary: 'Info',
          detail: 'Operacion cancelada',
        });
      },
    });
  }

  obtenerInformacion() {
    this.contactosService
      .getContactos(this.query, this.page, this.limit)
      .subscribe((contactos: any) => {
        if (contactos?.success) {
          this.totalRecords = contactos?.data?.total ?? 0;
          this.contactos = contactos?.data?.data ?? [];
        } else {
          this.messageService.add({
            severity: 'error',
            summary: 'Error',
            detail: 'Error al obtener la informacion',
          });
        }
        this.loading = false;
      });
  }

  createContacto() {
    this.loading = true;
    if (!this.contacto.nombre || !this.contacto.apellido_paterno) {
      this.messageService.add({
        severity: 'error',
        summary: 'Error',
        detail: 'Nombre y Apellido Paterno son requeridos',
      });
      return;
    }

    if (this.contacto.fecha_nacimiento) {
      this.contacto.fecha_nacimiento = new Date(this.contacto.fecha_nacimiento)
        .toISOString()
        .split('T')[0];
    }

    const sendData = {
      ...this.contacto,
      telefonos: this.telefonos,
      emails: this.emails,
      direcciones: this.direcciones,
    };
    try {
      this.contactosService
        .createContacto(sendData)
        .subscribe((contacto: any) => {
          if (contacto?.success) {
            this.messageService.add({
              severity: 'success',
              summary: 'Success',
              detail: 'Contacto creado correctamente',
            });
          } else {
            this.messageService.add({
              severity: 'error',
              summary: 'Error',
              detail: 'Error al crear el contacto',
            });
          }
          this.visible = false;
          this.loading = false;
          this.contacto = {};
          this.telefonos = [];
          this.emails = [];
          this.direcciones = [];
          this.obtenerInformacion();
        });
    } catch (error) {
      this.messageService.add({
        severity: 'error',
        summary: 'Error',
        detail: 'Error al crear el contacto',
      });
    }
  }

  updateContacto() {
    this.loading = true;
    if (!this.contacto.nombre || !this.contacto.apellido_paterno) {
      this.messageService.add({
        severity: 'error',
        summary: 'Error',
        detail: 'Nombre y Apellido Paterno son requeridos',
      });
      return;
    }

    if (this.contacto.fecha_nacimiento) {
      this.contacto.fecha_nacimiento = new Date(this.contacto.fecha_nacimiento)
        .toISOString()
        .split('T')[0];
    }

    const sendData = {
      ...this.contacto,
      telefonos: this.telefonos,
      emails: this.emails,
      direcciones: this.direcciones,
    };
    try {
      this.contactosService
        .updateContacto(sendData)
        .subscribe((contacto: any) => {
          if (contacto?.success) {
            this.messageService.add({
              severity: 'success',
              summary: 'Success',
              detail: 'Contacto actualizado correctamente',
            });
          } else {
            this.messageService.add({
              severity: 'error',
              summary: 'Error',
              detail: 'Error al actualizar el contacto',
            });
          }
          this.visible = false;
          this.loading = false;
          this.contacto = {};
          this.telefonos = [];
          this.emails = [];
          this.direcciones = [];
          this.obtenerInformacion();
        });
    } catch (error) {
      this.messageService.add({
        severity: 'error',
        summary: 'Error',
        detail: 'Error al crear el contacto',
      });
    }
  }

  editContacto(contacto: any) {
    this.activeIndex = 0;
    this.contacto = contacto;
    this.emails = contacto.emails;
    this.telefonos = contacto.telefonos;
    this.direcciones = contacto.direcciones;
    this.update = true;
    this.view = false;
    this.visible = true;
  }

  viewContacto(contacto: any) {
    this.activeIndex = 0;
    this.contacto = contacto;
    this.emails = contacto.emails;
    this.telefonos = contacto.telefonos;
    this.direcciones = contacto.direcciones;
    this.view = true;
    this.visible = true;
  }

  trackByFn(index: number, contacto: any) {
    return contacto.id;
  }

  showDialog() {
    this.contacto = {};
    this.telefonos = [];
    this.emails = [];
    this.direcciones = [];
    this.update = false;
    this.view = false;
    this.visible = true;
  }

  next() {
    this.activeIndex++;
  }
}
