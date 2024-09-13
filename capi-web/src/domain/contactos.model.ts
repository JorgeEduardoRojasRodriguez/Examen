export interface Contacto {
  id?: number;
  nombre?: string;
  apellido_paterno?: string;
  apellido_materno?: string;
  notas?: string;
  fecha_nacimiento?: string;
  pagina_web?: string;
  empresa?: string;
  created_at?: string;
  updated_at?: string;
}

export interface Telefonos {
  id?: number;
  contacto_id?: number;
  telefono?: string;
  created_at?: string;
  updated_at?: string;
}

export interface Emails {
  id?: number;
  contacto_id?: number;
  email?: string;
  created_at?: string;
  updated_at?: string;
}

export interface Direcciones {
  id?: number;
  calle?: string;
  numero?: string;
  colonia?: string;
  ciudad?: string;
  codigo_postal?: string;
  estado?: string;
  pais?: string;
  contacto_id?: number;
  created_at?: string;
  updated_at?: string;
}
