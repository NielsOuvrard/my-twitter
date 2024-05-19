// * //////////////////////////////////////// User

export interface BasicUserType {
  id: number;
  username: string;
  email: string;
  avatar?: string;
}

export interface FullUserType {
  id: number;
  username: string;
  email: string;
  bio?: string;
  avatar?: string;
  location?: string;
  job?: string;
  created_at: string;
}

// * //////////////////////////////////////// Message

export interface MessageWithUserType {
  id: number;
  user: BasicUserType;
  content: string;
  created_at: string;
}

export interface MinimalMessageType {
  id: number;
  content: string;
  created_at: string;
}

export interface MessagesFromType {
  user: BasicUserType;
  messages: MinimalMessageType[];
}

// * //////////////////////////////////////// Publication

export interface PublicationType {
  id: number;
  user: BasicUserType;
  content: string;
  likes?: number; // todo
  comments?: number; // todo
  created_at: string;
}
