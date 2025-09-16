import { UserIcon } from "@sanity/icons";
import { defineField, defineType } from "sanity";

export const adminType = defineType({
  name: "admin",
  title: "Admin User",
  type: "document",
  icon: UserIcon,
  fields: [
    defineField({
      name: "name",
      title: "Name",
      type: "string",
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: "email",
      title: "Email",
      type: "string",
      validation: (Rule) => Rule.required().email(),
    }),
    defineField({
      name: "role",
      title: "Role",
      type: "string",
      options: {
        list: [
          { title: "Admin", value: "admin" },
          { title: "Super Admin", value: "super_admin" },
        ],
        layout: "radio",
      },
      initialValue: "admin",
      validation: (Rule) => Rule.required(),
    }),
    defineField({
      name: "isActive",
      title: "Is Active",
      type: "boolean",
      description: "Whether this admin user is active and can login",
      initialValue: true,
    }),
    defineField({
      name: "password",
      title: "Password (Raw - will be hashed automatically)",
      type: "string",
      description: "⚠️ TEMPORARY VISIBLE: Enter raw password here. Must be at least 12 characters with uppercase, lowercase, numbers, and special characters. Will be hashed automatically when saved.",
      validation: (Rule) => Rule.required().min(12).custom((password) => {
        if (!password) return true; // Let required validation handle empty values
        
        const errors = [];
        if (!/[A-Z]/.test(password)) errors.push('Must contain uppercase letters');
        if (!/[a-z]/.test(password)) errors.push('Must contain lowercase letters');
        if (!/[0-9]/.test(password)) errors.push('Must contain numbers');
        if (!/[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/.test(password)) errors.push('Must contain special characters');
        
        return errors.length > 0 ? errors.join(', ') : true;
      }),
      hidden: false, // Temporarily visible for password setup
    }),
    defineField({
      name: "lastPasswordChange",
      title: "Last Password Change",
      type: "datetime",
      description: "Timestamp of the last password change",
      readOnly: true,
    }),
    defineField({
      name: "image",
      title: "Profile Image",
      type: "image",
      options: {
        hotspot: true,
      },
    }),
  ],
  preview: {
    select: {
      title: "name",
      subtitle: "email",
      media: "image",
      role: "role",
      isActive: "isActive",
    },
    prepare(selection) {
      const { title, subtitle, media, role, isActive } = selection;
      return {
        title: title,
        subtitle: `${subtitle} (${role}) ${isActive ? "✅" : "❌"}`,
        media: media,
      };
    },
  },
});